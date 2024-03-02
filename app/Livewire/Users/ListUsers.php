<?php

namespace App\Livewire\Users;

use App\Models\User;
use Filament\Tables;
use Livewire\Component;
use Filament\Tables\Table;

use Filament\Actions\StaticAction;
use Filament\Tables\Actions\Action;
use Filament\Tables\Grouping\Group;
use Illuminate\Contracts\View\View;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Rawilk\FilamentPasswordInput\Password;
use Illuminate\Database\Eloquent\Collection;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class ListUsers extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(User::query())
            ->columns([
                Tables\Columns\TextColumn::make('first_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('role')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Admin' => 'success',
                        'Student' => 'info',
                        'Teacher' => 'primary',
                        default => 'gray',
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),

                // Tables\Columns\TextColumn::make('profile_photo_path')
                //     ->searchable(),

            ])
            ->filters([
                //
            ])
            ->headerActions([

                CreateAction::make()
                    ->modalHeading('Create User')
                    ->label('New User')
                    ->form([


                        Section::make()
                            ->columns([
                                'sm' => 3,
                                'xl' => 6,
                                '2xl' => 8,
                            ])
                            ->schema([


                                TextInput::make('first_name')->required()->columnSpan(4),
                                TextInput::make('last_name')->required()->columnSpan(4),

                                TextInput::make('email')->required()->unique(ignoreRecord: true)
                                    ->columnSpan(4),
                                Select::make('role')
                                    ->required()
                                    ->label('Role')
                                    ->default('Teacher')
                                    ->options([
                                        'Admin' => 'Admin',
                                        'Student' => 'Student',
                                        'Teacher' => 'Teacher',
                                    ])

                                    ->columnSpan(4)
                                    ->searchable()
                                    ->live()
                                    ->hidden(fn (string $operation): bool => $operation === 'edit'),

                                Password::make('password')
                                    ->label(fn (string $operation) => $operation == 'create' ? 'Password' : 'New Password')
                                    ->password()
                                    ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                                    ->dehydrated(fn (?string $state): bool => filled($state))
                                    ->required(fn (string $operation): bool => $operation === 'create')
                                    ->columnSpan(4),

                                FileUpload::make('profile_photo_path')
                                    ->label('Profile')
                                    ->disk('public')
                                    ->directory('users-profiles')
                                    ->image()
                                    // ->imageEditorMode(2)
                                    ->columnSpanFull()

                            ]),




                        // TextInput::make('abbreviation')->maxLength(191)->required()->columnSpanFull(),
                    ])
                    ->modalWidth(MaxWidth::SevenExtraLarge)
                    ->disableCreateAnother(),
            ])
            ->actions([
                ActionGroup::make([
                    Action::make('view')
                        ->color('primary')
                        ->icon('heroicon-m-eye')
                        ->label('View Details')
                        ->modalContent(function (User $record) {
                            return view('livewire.users.user-details', ['record' => $record]);
                        })
                        ->modalSubmitAction(false)
                        ->modalCancelAction(fn (StaticAction $action) => $action->label('Close'))
                        ->disabledForm()
                        ->slideOver(),
                    EditAction::make('edit')
                        ->color('primary')
                        ->form([


                            Section::make()
                                ->columns([
                                    'sm' => 3,
                                    'xl' => 6,
                                    '2xl' => 8,
                                ])
                                ->schema([


                                    TextInput::make('first_name')->required()->columnSpan(4),
                                    TextInput::make('last_name')->required()->columnSpan(4),

                                    TextInput::make('email')->required()->unique(ignoreRecord: true)
                                        ->columnSpan(4),
                                    Select::make('role')
                                        ->required()
                                        ->label('Role')
                                        ->options([
                                            'Admin' => 'Admin',
                                            'Student' => 'Student',
                                            'Teacher' => 'Teacher',
                                        ])
                                        ->required()
                                        ->columnSpan(4)
                                        ->searchable()
                                        ->live()
                                        ->hidden(fn (string $operation): bool => $operation === 'edit'),

                                    Password::make('password')
                                        ->label(fn (string $operation) => $operation == 'create' ? 'Password' : 'New Password')
                                        ->password()
                                        ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                                        ->dehydrated(fn (?string $state): bool => filled($state))
                                        ->required(fn (string $operation): bool => $operation === 'create')
                                        ->columnSpan(4),

                                    FileUpload::make('profile_photo_path')
                                        ->disk('public')
                                        ->directory('users-profiles')
                                        ->image()

                                        ->label('Profile')

                                        // ->imageEditorMode(2)
                                        ->columnSpanFull(4)

                                ]),




                            // TextInput::make('abbreviation')->maxLength(191)->required()->columnSpanFull(),
                        ])
                        ->modalWidth(MaxWidth::SevenExtraLarge),
                    DeleteAction::make('delete'),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([


                    BulkAction::make('delete')
                        ->requiresConfirmation()
                        ->action(fn (Collection $records) => $records->each->delete())
                ])
                ->label('Actions')
                ,
            ])
            ->groups([
                Group::make('role')
                    ->titlePrefixedWithLabel(false),

            ])
            ->defaultGroup('role')
            ->modifyQueryUsing(fn (Builder $query) => $query->where('id', '!=', auth()->user()->id)->latest());
    }

    public function render(): View
    {
        return view('livewire.users.list-users');
    }
}
