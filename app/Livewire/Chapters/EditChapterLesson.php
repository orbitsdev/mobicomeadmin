<?php

namespace App\Livewire\Chapters;

use Filament\Forms;
use App\Models\Lesson;
use Livewire\Component;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Concerns\InteractsWithForms;

class EditChapterLesson extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public Lesson $record;

    public function mount(): void
    {
        $this->form->fill($this->record->attributesToArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Lesson')
                ->columns([
                    'sm' => 3,
                    'xl' => 6,
                    '2xl' => 8,
                ])
                ->schema([

                    TextInput::make('title')->required()->columnSpan(4),
                    Select::make('lesson_number_id')
                        ->relationship(
                            name: 'lesson_number',
                            titleAttribute: 'number',
                            modifyQueryUsing: fn (Builder $query) =>  $query->whereDoesntHave('lessons.chapter', function ($query) {
                                $query->where('id', $this->record->id);
                            })
                        )

                        ->preload()
                        ->columnSpan(4)
                        ->searchable()
                        ->required(),


                    RichEditor::make('content')

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

                        // ->required()
                        ->label('Display Image')
                        ->columnSpan(4),
                    FileUpload::make('video_path')
                        ->acceptedFileTypes(['video/*'])
                        ->disk('public')
                        ->directory('lessons-videos')
                        ->maxSize(20000)
                        ->columnSpan(4),])
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

        return redirect()->route('chapter-lessons-list',['record'=> $this->record->chapter]);
    }

    public function render(): View
    {
        return view('livewire.chapters.edit-chapter-lesson');
    }
}
