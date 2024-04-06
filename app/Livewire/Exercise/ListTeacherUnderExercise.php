<?php

namespace App\Livewire\Exercise;

use Filament\Tables;
use App\Models\Teacher;
use Livewire\Component;
use App\Models\Excercise;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class ListTeacherUnderExercise extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public Excercise  $record;

    public function table(Table $table): Table
    {
        return $table
            ->query(Teacher::query()->whereHas('enrolled_sections'))
            ->columns([
                TextColumn::make('user')->formatStateUsing(function ($state) {
                    return $state->getFullName();
                })
                    ->label('Name')
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->whereHas('user', function ($query) use ($search) {
                            $query->where('first_name', 'like', "%{$search}%")
                                ->orWhere('last_name', 'like', "%{$search}%");
                        });
                    }),

                    TextColumn::make('user.email')->label('Email')->searchable(),
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
            ]);
    }

    public function render(): View
    {
        return view('livewire.exercise.list-teacher-under-exercise');
    }
}
