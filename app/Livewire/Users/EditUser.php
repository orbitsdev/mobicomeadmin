<?php

namespace App\Livewire\Users;

use Filament\Forms;
use App\Models\User;
use Livewire\Component;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Forms\Components\FileUpload;
use Rawilk\FilamentPasswordInput\Password;
use Filament\Forms\Concerns\InteractsWithForms;

class EditUser extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public User $record;

    public function mount(): void
    {
        $this->form->fill($this->record->attributesToArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make('User')
                    ->columns([
                        'sm' => 3,
                        'xl' => 6,
                        '2xl' => 9,
                    ])
                    ->schema([
                        Forms\Components\TextInput::make('first_name')
                            ->maxLength(191)
                            ->columnSpan(3)
                            ->required(),
                        Forms\Components\TextInput::make('last_name')
                            ->required()
                            ->columnSpan(3)
                            ->maxLength(191),


                        Password::make('password')
                            ->label(fn (string $operation) => $operation == 'create' ? 'Password' : 'New Password')
                            ->password()
                            ->columnSpan(3)
                            ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                            ->dehydrated(fn (?string $state): bool => filled($state))
                            ->required(fn (string $operation): bool => $operation === 'create'),

                        FileUpload::make('profile_photo_path')
                        ->label('Profile')
                        ->disk('public')
                        ->directory('users-profiles')
                        ->image()
                            // ->required()
                            ->columnSpanFull(),
                    ]),

            ])
            ->statePath('data')
            ->model($this->record);
    }

    public function save()
    {
        $data = $this->form->getState();

        $this->record->update($data);

        Notification::make()
            ->title('Saved successfully')
            ->success()
            ->send();

        return redirect()->route('edit-profile', ['record'=>Auth::user()->id]);
    }

    public function render(): View
    {
        return view('livewire.users.edit-user');
    }
}
