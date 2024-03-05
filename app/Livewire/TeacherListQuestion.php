<?php

namespace App\Livewire;

use Filament\Tables;
use Livewire\Component;
use App\Models\Question;
use App\Models\Excercise;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class TeacherListQuestion extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;
    public Excercise $record;
    public function table(Table $table): Table
    {
        return $table
            ->query(Question::query())
            ->columns([
                Tables\Columns\TextColumn::make('question')
                ->numeric()
                ->sortable(),
            Tables\Columns\TextColumn::make('question_number.number')
                ->label('Questions')
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
            ]);
    }

    public function render(): View
    {
        return view('livewire.teacher-list-question');
    }
}
