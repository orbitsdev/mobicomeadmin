<?php

namespace App\Livewire\Chapters;

use Filament\Tables;
use App\Models\Chapter;
use Livewire\Component;
use Filament\Tables\Table;
use Filament\Actions\StaticAction;
use Filament\Tables\Actions\Action;
use Illuminate\Contracts\View\View;
use Filament\Forms\Components\Group;
use Filament\Support\Enums\MaxWidth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Awcodes\FilamentTableRepeater\Components\TableRepeater;

class ListChapters extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(Chapter::query())
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('chapter_number.number')

                    ->numeric()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('lessons_count')->counts('lessons')

            ])
            ->filters([
                //
            ])

            ->headerActions([

                CreateAction::make()
                    ->successNotificationTitle('Chapter Created')
                    ->label('New Chapter')
                    ->icon('heroicon-m-sparkles')

                    ->form([

                        Section::make()
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


                                // Select::make('chapter_number')->options([
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
                                    // ->required()
                                    ->label('Display Image')


                                    ->columnSpanFull()

                            ]),

                           




                        // TextInput::make('abbreviation')->maxLength(191)->required()->columnSpanFull(),
                    ])
                    ->modalWidth(MaxWidth::Full)
                    ->slideOver()
                    ->disableCreateAnother(),
            ])
            ->actions([
                Action::make('Manage Lessons')
                    ->color('primary')
                    ->icon('heroicon-m-cursor-arrow-rays')
                    ->label('Manage Lessons')
                    ->url(function (Chapter $record) {
                        // return ('livewire.chapters.manage-lessons', ['record' => $record]);
                        return route('manage-chapter-lessons', ['record' => $record]);
                    }),

                ActionGroup::make([
                    Action::make('view')
                        ->color('primary')
                        ->icon('heroicon-m-eye')
                        ->label('View Chapter ')
                        ->modalContent(function (Chapter $record) {
                            return view('livewire.chapters.chapter-details', ['record' => $record]);
                        })
                        ->modalSubmitAction(false)
                        ->modalCancelAction(fn (StaticAction $action) => $action->label('Close'))
                        ->disabledForm()
                        ->modalWidth(MaxWidth::Full)
                        ->slideOver(),

                    EditAction::make('edit')
                        ->label('Edit Chapter')
                        ->successNotificationTitle('Updated Save')
                        ->color('primary')
                        ->form([
                            Section::make()
                                ->columns([
                                    'sm' => 3,
                                    'xl' => 6,
                                    '2xl' => 8,
                                ])
                                ->schema([


                                    TextInput::make('title')->required()->columnSpan(4)

                                    ,
                                     Select::make('chapter_number_id')
                                    ->relationship(
                                        name: 'chapter_number',
                                        titleAttribute: 'number',
                                        modifyQueryUsing: fn (Builder $query) => $query->whereDoesntHave('chapter')->orderBy('number'),
                                    )
                                    // ->unique(ignoreRecord: true)
                                    ->preload()
                                       ->columnSpan(4)
                                    ->searchable()
                                      ->required()
                                    ,
                                    // Select::make('chapter_number')->options([
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
                                    //     ->required()
                                    //     ->columnSpan(4)
                                    //     ->unique(ignoreRecord: true)
                                    //     ->searchable(),


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

                                        ->columnSpanFull()


                                        ->columnSpanFull(),
                                    FileUpload::make('image_path')
                                        ->disk('public')
                                        ->directory('chapters-images')
                                        ->image()
                                        // ->required()
                                        ->label('Display Image')


                                        ->columnSpanFull()
                                ])

                        ])
                        ->modalWidth(MaxWidth::Full)
                        ->slideOver()
                        ,
                    DeleteAction::make('delete'),
                ]),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([


                    BulkAction::make('delete')
                        ->requiresConfirmation()
                        ->action(fn (Collection $records) => $records->each->delete())
                ])
                    ->label('Actions'),
            ])
            ->modifyQueryUsing(fn (Builder $query) => $query->join('chapter_numbers', 'chapters.chapter_number_id', '=', 'chapter_numbers.id')
            ->orderBy('chapter_numbers.number'));
    }

    public function render(): View
    {
        return view('livewire.chapters.list-chapters');
    }
}
