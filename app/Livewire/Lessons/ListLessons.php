<?php

namespace App\Livewire\Lessons;

use Filament\Tables;
use App\Models\Lesson;

use Filament\Forms\Get;
use Filament\Forms\Set;
use Livewire\Component;
use Filament\Tables\Table;
use Filament\Actions\StaticAction;
use Filament\Tables\Actions\Action;
use Filament\Tables\Grouping\Group;
use Illuminate\Contracts\View\View;
use Filament\Support\Enums\MaxWidth;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class ListLessons extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(Lesson::query())
            ->columns([

               TextColumn::make('title')
                    ->searchable(),
                    TextColumn::make('lesson_number.number')->searchable(),
               TextColumn::make('chapter.title')
                    ->searchable(),
                // Tables\Columns\ImageColumn::make('image_path'),
                // Tables\Columns\TextColumn::make('video_path')
                //     ->searchable(),
                // Tables\Columns\ImageColumn::make('image_type'),
                // Tables\Columns\TextColumn::make('video_type')
                //     ->searchable(),
                // Tables\Columns\TextColumn::make('lesson_number')
                //     ->numeric()
                //     ->sortable(),

            ])
            ->filters([
                SelectFilter::make('chapter')
                    ->relationship('chapter', 'title')
            ])
            ->headerActions([

                // CreateAction::make()
                //     ->successNotificationTitle('Lesson Created')
                //     ->label('New Lesson')
                //     ->icon('heroicon-m-sparkles')

                //     ->mutateFormDataUsing(function (array $data): array {


                //         if (!empty($data['image_path'])) {
                //             $data['image_type'] = Storage::disk('public')->mimeType($data['image_path']);
                //         }
                //         if (!empty($data['video_path'])) {
                //             $data['video_type'] = Storage::disk('public')->mimeType($data['video_path']);
                //         }

                //         return $data;
                //     })

                //     ->form(
                //         [

                //             Section::make()
                //                 ->columns([
                //                     'sm' => 8,
                //                     'md' => 8,
                //                     'xl' => 8,
                //                     '2xl' => 8,
                //                 ])
                //                 ->schema([

                //                     Select::make('chapter_id')
                //                     ->label('Select Chapter')
                //                         ->relationship(
                //                             name: 'chapter',
                //                             titleAttribute: 'title',
                //                         )
                //                         ->live(debounce: 500)
                //                     //    ->live()
                //                        ->formatStateUsing(function(Get $get, Set $set){
                //                         $set('lesson_number_id', null);
                //                             // dd($get('lesson_number_id'));
                //                        })


                                 

                //                         ->preload()
                //                         ->columnSpanFull()
                //                         ->searchable()
                //                         ->required(),
                //                     TextInput::make('title')->required()
                //                     ->columnSpanFull()
                //                     ,
                //                     Select::make('lesson_number_id')
                //                         ->relationship(
                //                             name: 'lesson_number',
                //                             titleAttribute: 'number',
                //                             modifyQueryUsing: fn (Builder $query, Get $get) =>  $query->whereDoesntHave('lessons.chapter', function ($query) use($get){
                //                                 $query->where('id', $get('chapter_id'));
                //                             })
                //                         )
                //                         ->visible(fn (Get $get): bool => !empty($get('chapter_id')))       
                //                         ->preload()
                //                         ->columnSpanFull()
                                        
                //                         ->native(false)
                                      
                //                         ->searchable()
                //                         ->required(),



                //                     RichEditor::make('content')

                //                         ->toolbarButtons([

                //                             'blockquote',
                //                             'bold',
                //                             'bulletList',
                //                             'codeBlock',
                //                             'h2',
                //                             'h3',
                //                             'italic',
                //                             'link',
                //                             'orderedList',
                //                             'redo',
                //                             'strike',
                //                             'underline',
                //                             'undo',
                //                         ])
                //                         ->columnSpanFull(),
                //                     FileUpload::make('image_path')
                //                         ->disk('public')
                //                         ->directory('chapters-images')
                //                         ->image()

                //                         // ->required()
                //                         ->label('Display Image')
                //                         ->columnSpan(4),
                //                     FileUpload::make('video_path')
                //                         ->acceptedFileTypes(['video/*'])
                //                         ->disk('public')
                //                         ->directory('lessons-videos')
                //                         ->maxSize(20000)
                //                         ->columnSpan(4),

                //                 ]),




                //         ]
                //     )
                //     ->closeModalByClickingAway(false)
                //     ->modalWidth(MaxWidth::SevenExtraLarge)
                //     ->slideOver()
                //     ->disableCreateAnother(),
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
                        ->closeModalByClickingAway(false),

                    // EditAction::make('edit')
                    //     ->successNotificationTitle('Lesson updated')
                    //     ->color('primary')
                    //     ->mutateRecordDataUsing(function (array $data): array {

                    //         if (!empty($data['image_path'])) {
                    //             $data['image_type'] = Storage::disk('public')->mimeType($data['image_path']);
                    //         }
                    //         if (!empty($data['video_path'])) {
                    //             $data['video_type'] = Storage::disk('public')->mimeType($data['video_path']);
                    //         }


                    //         return $data;
                    //     })
                    //     ->form([
                    //         Section::make()
                    //         ->columns([
                    //             'sm' => 8,
                    //             'md' => 8,
                    //             'xl' => 8,
                    //             '2xl' => 8,
                    //         ])
                    //         ->schema([

                    //             Select::make('chapter_id')
                    //             ->label('Select Chapter')
                    //                 ->relationship(
                    //                     name: 'chapter',
                    //                     titleAttribute: 'title',
                    //                 )
                    //                 ->live(debounce: 500)
                    //             //    ->live()
                    //                ->formatStateUsing(function(Get $get, Set $set){
                    //                 $set('lesson_number_id', null);
                    //                     // dd($get('lesson_number_id'));
                    //                })


                             

                    //                 ->preload()
                    //                 ->columnSpanFull()
                    //                 ->searchable()
                    //                 ->required(),
                    //             TextInput::make('title')->required()
                    //             ->columnSpanFull()
                    //             ,
                    //             Select::make('lesson_number_id')
                    //                 ->relationship(
                    //                     name: 'lesson_number',
                    //                     titleAttribute: 'number',
                    //                     modifyQueryUsing: fn (Builder $query, Get $get) =>  $query->whereDoesntHave('lessons.chapter', function ($query) use($get){
                    //                         $query->where('id', $get('chapter_id'));
                    //                     })
                    //                 )
                    //                 ->visible(fn (Get $get): bool => !empty($get('chapter_id')))       
                    //                 ->preload()
                    //                 ->columnSpanFull()
                                    
                    //                 ->native(false)
                                  
                    //                 ->searchable()
                    //                 ->required(),



                    //             RichEditor::make('content')

                    //                 ->toolbarButtons([

                    //                     'blockquote',
                    //                     'bold',
                    //                     'bulletList',
                    //                     'codeBlock',
                    //                     'h2',
                    //                     'h3',
                    //                     'italic',
                    //                     'link',
                    //                     'orderedList',
                    //                     'redo',
                    //                     'strike',
                    //                     'underline',
                    //                     'undo',
                    //                 ])
                    //                 ->columnSpanFull(),
                    //             FileUpload::make('image_path')
                    //                 ->disk('public')
                    //                 ->directory('chapters-images')
                    //                 ->image()

                    //                 // ->required()
                    //                 ->label('Display Image')
                    //                 ->columnSpan(4),
                    //             FileUpload::make('video_path')
                    //                 ->acceptedFileTypes(['video/*'])
                    //                 ->disk('public')
                    //                 ->directory('lessons-videos')
                    //                 ->maxSize(20000)
                    //                 ->columnSpan(4),

                    //         ]),

                    //     ])
                    //     ->modalWidth(MaxWidth::SevenExtraLarge)
                    //     ->slideOver(),
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


            ->groups([
                Group::make('chapter.title')
                    ->titlePrefixedWithLabel(false)
                    ->label('Chapter'),
            ])
            ->modifyQueryUsing(fn (Builder $query) => $query->leftJoin('lesson_numbers', 'lessons.lesson_number_id', '=', 'lesson_numbers.id')
                ->orderBy('lesson_numbers.number',));
    }

    public function render(): View
    {
        return view('livewire.lessons.list-lessons');
    }
}
