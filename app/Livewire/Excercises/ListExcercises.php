<?php

namespace App\Livewire\Excercises;

use Filament\Tables;
use App\Models\Lesson;
use Livewire\Component;
use App\Models\Excercise;
use Filament\Tables\Table;
use Livewire\Attributes\Layout;
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
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class ListExcercises extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(Excercise::query())
            ->columns([
                // Tables\Columns\TextColumn::make('exerciseable_id')
                //     ->numeric()
                //     ->sortable(),
                // Tables\Columns\TextColumn::make('exerciseable_type')
                //     ->searchable(),
              TextColumn::make('title')
                    ->searchable(),
              TextColumn::make('type')
              ->badge()
                    ->searchable(),

                    Tables\Columns\TextColumn::make('questions_count')->counts('questions')->label('Number of Questions'),


    //                 TextColumn::make('questions.content')
    // ->listWithLineBreaks()
    // ->bulleted()
                // Tables\Columns\TextColumn::make('user_id')
                //     ->numeric()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('created_by')
                    ->searchable(),
                // Tables\Columns\IconColumn::make('is_lock')
                //     ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->date()
                    ->sortable()

                    
                //     ->toggleable(isToggledHiddenByDefault: true),
                // Tables\Columns\TextColumn::make('updated_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('type')
    ->options([
        'Multiple Choice' => 'Multiple Choice',
        'True or False' => 'True or False',
        'Fill in the Blank' => 'Fill in the Blank',
    ]),

     SelectFilter::make('created_by')
    ->options([
        'Teacher' => 'Teacher',
        'Admin' => 'Admin',
    ])
    ], layout: FiltersLayout::AboveContent)


            ->headerActions([

                Action::make('New Excecise')
                ->color('primary')
                ->icon('heroicon-m-sparkles')
                ->label('New Exercise')
                ->url(function () {
                    // return ('livewire.chapters.manage-lessons', ['record' => $record]);
                    return route('create-exercise');
                }),


            ])
            ->actions([
                Action::make('Manage Excercise')
                ->color('primary')
                ->icon('heroicon-m-cursor-arrow-rays')
                ->label('Manage Questions')
                ->url(function (Model $record) {

                    return $record->redirectBaseOnExerciseType();

                    // return ('livewire.chapters.manage-lessons', ['record' => $record]);
                    // return route('manage-exercise', ['record' => $record]);
                }),

                ActionGroup::make([
                    Action::make('view')
                        ->color('primary')
                        ->icon('heroicon-m-eye')
                        ->label('View Excercise')
                        ->url(function (Model $record) {
                            // return ('livewire.chapters.manage-lessons', ['record' => $record]);
                            return route('view-exercise', ['record' => $record]);
                        }),

                        Action::make('Edit Exercise')
                        ->color('primary')
                        ->icon('heroicon-m-pencil-square')
                        ->label('Edit Exercise')
                        ->url(function (Model $record) {
                            // return ('livewire.chapters.manage-lessons', ['record' => $record]);
                            return route('edit-exercise', ['record' => $record]);
                        }),


                    DeleteAction::make('delete'),
                ]),
                //
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([

                    BulkAction::make('delete')
                        ->requiresConfirmation()
                        ->action(fn (Collection $records) => $records->each->delete())
                ])
                    ->label('Actions'),
            ])
            // ->groups([
            //     Group::make('type')
            //     ->titlePrefixedWithLabel(false),
            // ])
            // ->defaultGroup('type')
            ;
    }

    public function render(): View
    {
        return view('livewire.excercises.list-excercises');
    }
}
