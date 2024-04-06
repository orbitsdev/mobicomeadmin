<?php

namespace App\Livewire\Exercise;

use Filament\Tables;
use Livewire\Component;
use App\Models\Excercise;
use App\Models\TakedExam;
use Filament\Tables\Table;
use Filament\Tables\Grouping\Group;
use Illuminate\Contracts\View\View;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class ListTakedExam extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public Excercise $record;

    public function table(Table $table): Table
    {
        return $table
            ->query(TakedExam::query())
            ->columns([
                Tables\Columns\TextColumn::make('student_id')->formatStateUsing(function(Model $record){
                    return $record->student?->user->getFullName();
                })->label('Student'),
                    

           
                Tables\Columns\TextColumn::make('created_at')
                    ->date()
                    ->label('Date')
                    
                
            ])
            ->filters([
                //
            ])
            ->actions([
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
                Group::make('student.enrolled_section.created_at')
                    ->label('Section')
                    // ->titlePrefixedWithLabel(false)
                    ,
            ]);
    
    }

    public function render(): View
    {
        return view('livewire.exercise.list-taked-exam');
    }
}
