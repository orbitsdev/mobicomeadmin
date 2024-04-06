<?php

namespace App\Livewire\Chapters;

use Filament\Forms;
use App\Models\Chapter;
use Livewire\Component;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Concerns\InteractsWithForms;

class CreateChapter extends Component implements HasForms
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
                Section::make('Create Chapter')
                            ->columns([
                                'sm' => 3,
                                'xl' => 6,
                                '2xl' => 8,
                            ])
                            ->schema([

                                TextInput::make('title')->required()->columnSpan(4),
                                    Select::make('chapter_number_id')
                                        ->relationship(
                                            name: 'chapter_number',
                                            titleAttribute: 'number',
                                            modifyQueryUsing: fn (Builder $query) => $query->whereDoesntHave('chapter')->orderBy('number'),
                                        )
                                        ->unique(ignoreRecord: true)
                                        ->preload()
                                           ->columnSpan(4)
                                        ->searchable()
                                          ->required()
                                        ,
                                
                                RichEditor::make('description')

                                ->toolbarButtons([
                                    'attachFiles',
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

                                ->columnSpanFull(),

                            FileUpload::make('image_path')
                                ->disk('public')
                                ->directory('chapters-images')
                                ->image()
                                 ->required()
                                ->label('Display Image')


                                ->columnSpanFull()

                              



                            ]),
            ])
            ->statePath('data')
            ->model(Chapter::class);
    }

    public function create()
    {
        $data = $this->form->getState();
        

        $data['user_id'] =  Auth::user()->id;
        $record = Chapter::create($data);

        $this->form->model($record)->saveRelationships();

        Notification::make()
        ->title('Saved successfully')
        ->success()
        ->send();

        return redirect()->route('list-chapters');
    }

    public function render(): View
    {
        return view('livewire.chapters.create-chapter');
    }
}
