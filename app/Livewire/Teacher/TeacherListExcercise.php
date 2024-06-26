<?php

namespace App\Livewire\Teacher;

use App\Models\User;
use Filament\Tables;
use Livewire\Component;
use App\Models\Excercise;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class TeacherListExcercise extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(Excercise::query())
            ->columns([
         
              TextColumn::make('title')
              ->searchable(),
        TextColumn::make('type')
        ->badge()
              ->searchable(),

              Tables\Columns\TextColumn::make('questions_count')->counts('questions')->label('Number of Questions'),

              Tables\Columns\TextColumn::make('user_id')->label('Created by')
              ->formatStateUsing(function (Model $record) {
                  return $record?->user?->getFullNameWithRole() ?? '';
              })
              ->color(fn (Model $record): string => match ($record->user->role) {
                  User::ADMIN => 'info',
                  User::TEACHER => 'success',
                  default => 'gray',

              })
              ->badge()
              ->searchable(),
//                 TextColumn::make('questions.content')
// ->listWithLineBreaks()
// ->bulleted()
          // Tables\Columns\TextColumn::make('user_id')
          //     ->numeric()
          //     ->sortable(),
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
                        return route('teacher-create-exercise');
                    }),


            ])
            ->actions([
                
                Action::make('Manage Excercise')
                ->color('primary')
                ->icon('heroicon-m-cursor-arrow-rays')
                ->label('Manage Questions')
                ->url(function (Model $record) {

                    return $record->teacherRedirectBaseOnExerciseType();

                    // return ('livewire.chapters.manage-lessons', ['record' => $record]);
                    // return route('manage-exercise', ['record' => $record]);
                }),

                Action::make('Response')
                ->color('primary')

                
                // ->icon('heroicon-m-pencil')
                ->label(function(Model $record){
                    if(Auth::user()->isAdmin()){
                        return 'Response ('. $record->taked_exams->count().')'; 
                        
                    }else{
                        
                        return 'Response ('. $record->taked_exams()->whereHas('student.enrolled_section.teacher', function($query){
                            $query->where('user_id', Auth::user()->id);
                        })->count().')'; 
                    }
                })
                ->button()
                ->outlined()
                ->url(function (Model $record) {

                    return route('exercise-taked-exams-by-sections',['record'=> $record]);

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
                        return route('teacher-view-exercise', ['record' => $record]);
                    }),

                Action::make('Edit Exercise')
                    ->color('primary')
                    ->icon('heroicon-m-pencil-square')
                    ->label('Edit Exercise')
                    ->url(function (Model $record) {
                        // return ('livewire.chapters.manage-lessons', ['record' => $record]);
                        return route('teacher-edit-exercise', ['record' => $record]);
                    })
                    ->hidden(function (Model $record) {

                        $authenticated_id = Auth::id();

                        if (!empty($record->user_id)) {
                            switch (Auth::user()->role) {
                                case User::ADMIN:
                                    return false;
                                case User::TEACHER:
                                    return $record->user_id !== $authenticated_id;
                                case User::STUDENT:
                                    return true;
                            }
                        } else {
                            return Auth::user()->isStudent();
                        }
                    })
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
            ]);
    }

    public function render(): View
    {
        return view('livewire.teacher.teacher-list-excercise');
    }
}
