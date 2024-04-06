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
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
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
                Tables\Columns\TextColumn::make('student_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('excercise_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('completed')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //
                ]),
            ])
            ->groups([
                Group::make('student.enrolled_section.section.title')
                    ->label('Section')
                    ->titlePrefixedWithLabel(false)
                    ,
            ]);
    
    }

    public function render(): View
    {
        return view('livewire.exercise.list-taked-exam');
    }
}
