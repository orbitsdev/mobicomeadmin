<?php

namespace App\Livewire\Chapters;

use Filament\Tables;
use App\Models\Lesson;
use App\Models\Chapter;
use Livewire\Component;
use Filament\Tables\Table;
use Filament\Actions\StaticAction;
use Filament\Tables\Actions\Action;
use Illuminate\Contracts\View\View;
use Filament\Support\Enums\MaxWidth;
use Filament\Forms\Components\Select;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Forms\Components\Section as FSection;

class ListLessons extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;


    public  Chapter $record;
    public function table(Table $table): Table
    {
        return $table
            ->query(Lesson::query())
            ->columns([



                TextColumn::make('title')
                ->searchable(),
                TextColumn::make('lesson_number.number')->searchable(),
                // Tables\Columns\ImageColumn::make('image_path'),
                // Tables\Columns\TextColumn::make('video_path')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('lesson_number')
                //     ->numeric()
                //     ->sortable(),

            ])
            ->filters([
                //
            ])

            ->headerActions([

                CreateAction::make()
                ->successNotificationTitle('Lesson Created')
                    ->label('New Lesson')
                    ->icon('heroicon-m-sparkles')

                    ->mutateFormDataUsing(function (array $data): array {
                        $data['chapter_id'] = $this->record->id;

                        if(!empty($data['image_path'])){
                            $data['image_type'] = Storage::disk('public')->mimeType($data['image_path']);

                        }
                        if(!empty($data['video_path'])){
                            $data['video_type'] = Storage::disk('public')->mimeType($data['video_path']);

                        }

                        return $data;
                    })

                    ->form([

                        FSection::make()
                            ->columns([
                                'sm' => 8,
                                'md' => 8,
                                'xl' => 8,
                                '2xl' => 8,
                            ])
                            ->schema([


                                TextInput::make('title')->required()->columnSpan(2),

                                Select::make('lesson_number_id')
                                ->relationship(
                                    name: 'lesson_number',
                                    titleAttribute: 'number',
                                    modifyQueryUsing: fn (Builder $query) =>  $query->whereDoesntHave('lessons.chapter', function($query){
                                        $query->where('id', $this->record->id);
    }))

                                ->preload()
                                   ->columnSpan(4)
                                ->searchable()
                                  ->required()
                                ,
                                TextInput::make('title_number')->required()->columnSpan(2)
                                ->helperText('ex. 1.1'),

                                // Select::make('lesson_number')->options([
                                //     1 => '1',    2 => '2',    3 => '3',    4 => '4',    5 => '5',
                                //     6 => '6',    7 => '7',    8 => '8',    9 => '9',    10 => '10',
                                //     11 => '11',  12 => '12',  13 => '13',  14 => '14',  15 => '15',
                                //     16 => '16',  17 => '17',  18 => '18',  19 => '19',  20 => '20',
                                //     21 => '21',  22 => '22',  23 => '23',  24 => '24',  25 => '25',
                                //     26 => '26',  27 => '27',  28 => '28',  29 => '29',  30 => '30',
                                //     31 => '31',  32 => '32',  33 => '33',  34 => '34',  35 => '35',
                                //     36 => '36',  37 => '37',  38 => '38',  39 => '39',  40 => '40',
                                //     41 => '41',  42 => '42',  43 => '43',  44 => '44',  45 => '45',
                                //     46 => '46',  47 => '47',  48 => '48',  49 => '49',  50 => '50',
                                //     51 => '51',  52 => '52',  53 => '53',  54 => '54',  55 => '55',
                                //     56 => '56',  57 => '57',  58 => '58',  59 => '59',  60 => '60',
                                //     61 => '61',  62 => '62',  63 => '63',  64 => '64',  65 => '65',
                                //     66 => '66',  67 => '67',  68 => '68',  69 => '69',  70 => '70',
                                //     71 => '71',  72 => '72',  73 => '73',  74 => '74',  75 => '75',
                                //     76 => '76',  77 => '77',  78 => '78',  79 => '79',  80 => '80',
                                //     81 => '81',  82 => '82',  83 => '83',  84 => '84',  85 => '85',
                                //     86 => '86',  87 => '87',  88 => '88',  89 => '89',  90 => '90',
                                //     91 => '91',  92 => '92',  93 => '93',  94 => '94',  95 => '95',
                                //     96 => '96',  97 => '97',  98 => '98',  99 => '99',  100 => '100',
                                // ])
                                // ->required()
                                // ->columnSpan(4)
                                // ->unique(ignoreRecord:true)
                                // ->searchable(),

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
                                    ->columnSpanFull()

                                    ,
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
                                    ->columnSpan(4)
                                    ,

                            ]),




                        // TextInput::make('abbreviation')->maxLength(191)->required()->columnSpanFull(),
                    ]
                    )
                    ->closeModalByClickingAway(false)
                    ->modalWidth(MaxWidth::Full)
                    ->slideOver()
                    ->disableCreateAnother(),
            ])
            ->actions([
                ActionGroup::make([
                    Action::make('view')
                        ->color('primary')
                        ->icon('heroicon-m-eye')
                        ->label('View Lesson')
                        // ->url(fn (Model $record): string => route('view-lesson-details', ['record' => $record]))
                        ->modalContent(function (Lesson $record) {
                            return view('livewire.chapters.lesson-details', ['record' => $record]);
                        })
                        ->modalWidth(MaxWidth::Full)
                        ->modalSubmitAction(false)
                        ->modalCancelAction(fn (StaticAction $action) => $action->label('Close'))
                        ->disabledForm()
                        ->slideOver()
                        ->closeModalByClickingAway(false)
                        ,

                    EditAction::make('edit')
                    ->successNotificationTitle('Lesson updated')
                        ->color('primary')
                        ->mutateRecordDataUsing(function (array $data): array {

                            if(!empty($data['image_path'])){
                                $data['image_type'] = Storage::disk('public')->mimeType($data['image_path']);

                            }
                            if(!empty($data['video_path'])){
                                $data['video_type'] = Storage::disk('public')->mimeType($data['video_path']);

                            }


                            return $data;
                        })
                        ->form([
                            FSection::make()
                            ->columns([
                                'sm' => 3,
                                'xl' => 8,
                                '2xl' => 8,
                            ])
                            ->schema([


                                TextInput::make('title')->required()->columnSpan(4),
                                Select::make('lesson_number_id')
                                ->relationship(
                                    name: 'lesson_number',
                                    titleAttribute: 'number',
                                    modifyQueryUsing: fn (Builder $query) =>  $query->whereDoesntHave('lessons.chapter', function($query){
                                        $query->where('id', $this->record->id);
    }))

                                ->preload()
                                   ->columnSpan(4)
                                ->searchable()
                                  ->required()
                                ,


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
                                    ->columnSpanFull()

                                    ,
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
                                    ->columnSpan(4)
                                    ,

                            ]),

                        ])
                        ->modalWidth(MaxWidth::Full)
                        ->slideOver(),
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
            ->modifyQueryUsing(fn (Builder $query) => $query->where('chapter_id', $this->record->id)->join('lesson_numbers', 'lessons.lesson_number_id', '=', 'lesson_numbers.id')
            ->orderBy('lesson_numbers.number', 'asc'))
            ;
    }

    public function render(): View
    {
        return view('livewire.chapters.list-lessons');
    }
}
