<?php

namespace App\Livewire\Teacher\Management;

use Filament\Tables;
use Livewire\Component;
use App\Models\TakedExam;
use Filament\Tables\Table;
use Filament\Actions\StaticAction;
use Filament\Tables\Actions\Action;
use Filament\Tables\Grouping\Group;
use Illuminate\Contracts\View\View;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class ListTakedExcercise extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(TakedExam::query()->whereHas('student.enrolled_section.teacher.user', function($query){
                $query->where('id', Auth::user()->id);
            }))
            ->columns([
                Tables\Columns\TextColumn::make('excercise.title')->searchable()->label('Exercise'),
                Tables\Columns\TextColumn::make('student_id')->formatStateUsing(function (Model $record) {
                    return $record->student?->user->getFullName();
                })->label('Student'),



            ViewColumn::make(' ')->view('tables.columns.exercise-score')
                    ->label('Score'),


                    Tables\Columns\TextColumn::make('student.enrolled_section.teacher')->formatStateUsing(function ($state) {
                        return $state?->user->getFullName();
                    })
                    ->badge()
                    ->color('success')
                    ->label('Teacher'),
                    
                Tables\Columns\TextColumn::make('created_at')
                ->date()
                ->label('Date'),
            
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('view')
                ->color('primary')
                ->label('View Score')

                ->button()


                ->outlined()
                ->modalSubmitAction(false)
                ->modalCancelAction(fn (StaticAction $action) => $action->label('Close'))
                ->disabledForm()
                ->modalContent(fn (Model $record): View => view(
                    'livewire.exercise.view-official-result',
                    ['record' => $record],
                ))
                ->modalWidth(MaxWidth::SevenExtraLarge),
                DeleteAction::make('delete'),
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
                Group::make('student.enrolled_section.section.title')
                ->label('Section'),
                Group::make('excercise.title')
                    ->label('Exercise')
                    ->titlePrefixedWithLabel(false),
                    
            ])
            ->defaultGroup('student.enrolled_section.section.title')
            // ->default('excercise.title')
             ;
    }

    public function render(): View
    {
        return view('livewire.teacher.management.list-taked-excercise');
    }
}
