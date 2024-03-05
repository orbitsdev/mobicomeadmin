<?php

namespace App\Livewire\Teacher;

use Filament\Forms;
use Livewire\Component;
use Filament\Forms\Form;
use App\Models\Excercise;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Concerns\InteractsWithForms;

class TeacherCreateExcercise extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                ->columns([
                    'sm' => 3,
                    'xl' => 6,
                    '2xl' => 8,
                ])
                ->schema([


                    TextInput::make('title')->required()->columnSpan(4),
                    Select::make('type')
                        ->options([
                            'Multiple Choice' => 'Multiple Choice',
                            'True or False' => 'True or False',
                            'Fill in the Blank' => 'Fill in the Blank',
                        ])
                        ->default('Multiple Choice')
                        ->required()
                        ->columnSpan(4),




                    RichEditor::make('description')

                        ->toolbarButtons([

                            'blockquote',
                            'bold',
                            'bulletList',
                            'codeBlock',
                            'h2',
                            'h3',
                            'italic',
                            'link',
                            'orderedList',
                            'redo',
                            'strike',
                            'underline',
                            'undo',
                        ])
                        ->required()
                        ->columnSpanFull(),






                    // FileUpload::make('image_path')
                    //     ->disk('public')
                    //     ->directory('chapters-images')
                    //     ->image()
                    //     // ->required()
                    //     ->label('Display Image')


                    //     ->columnSpanFull()

                ]),
            ])
            ->statePath('data')
            ->model(Excercise::class);
    }

    public function create()
    {
        $data = $this->form->getState();
        $user  =Auth::user();
        $data['user_id']= $user->id;
        $data['created_by']= $user->role;

        $record = Excercise::create($data);

        $this->form->model($record)->saveRelationships();
         Notification::make()
        ->title('Saved successfully')
        ->success()
        ->send();

        return redirect()->route('teacher-list-excercises');
    }

    public function render(): View
    {
        return view('livewire.teacher.teacher-create-excercise');
    }
}