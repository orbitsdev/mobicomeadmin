<?php

namespace App\Livewire\Exercise;

use Filament\Tables;
use App\Models\Section;
use Livewire\Component;
use App\Models\Excercise;
use App\Models\TakedExam;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Grouping\Group;
use Illuminate\Contracts\View\View;
use Filament\Forms\Components\Select;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Filters\Indicator;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Filters\QueryBuilder\Constraints\SelectConstraint;

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
                Tables\Columns\TextColumn::make('student_id')->formatStateUsing(function (Model $record) {
                    return $record->student?->user->getFullName();
                })->label('Student'),



                Tables\Columns\TextColumn::make('created_at')
                    ->date()
                    ->label('Date')


            ])
            ->filters([

                Filter::make('section')
                ->form([
                    Select::make('section_id')
                        ->options(Section::whereHas('enrolled_sections')->get()->pluck('title', 'id'))
                        ->label('Section')

                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['section_id'], fn (Builder $query) => $query->whereHas('student.enrolled_section', function($query) use($data){ 
                                $query->where('section_id', $data['section_id']);
                            }),
                        );
                })

            ], layout: FiltersLayout::AboveContent)
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
                Group::make('student.enrolled_section.section.title')
                    ->label('Section')
                // ->titlePrefixedWithLabel(false)
                ,
            ])
            ->defaultGroup('student.enrolled_section.section.title')
            ;
    }

    public function render(): View
    {
        return view('livewire.exercise.list-taked-exam');
    }
}
