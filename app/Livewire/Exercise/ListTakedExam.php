<?php

namespace App\Livewire\Exercise;

use Filament\Tables;
use App\Models\Section;
use App\Models\Teacher;
use Livewire\Component;
use App\Models\Excercise;
use App\Models\TakedExam;
use Filament\Tables\Table;
use Filament\Actions\StaticAction;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Grouping\Group;
use Illuminate\Contracts\View\View;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Filters\Indicator;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Forms\Components\Section as FSection;
use Filament\Tables\Filters\QueryBuilder\Constraints\SelectConstraint;

class ListTakedExam extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public Excercise $record;

    public function table(Table $table): Table
    {
        return $table
            ->query(function(){
                if(Auth::user()->isAdmin()){
                    return TakedExam::query()->where('excercise_id', $this->record->id);
                }else{
                    return TakedExam::query()->where('excercise_id', $this->record->id)->whereHas('student.enrolled_section.teacher', function($query){
                        $query->where('user_id', Auth::user()->id);
                    });

                }
            })
            ->columns([
               
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

                Filter::make('section')
                ->form([

                     FSection::make()
                            ->columns([
                                'sm' => 3,
                                'xl' => 6,
                                '2xl' => 8,
                            ])
                            ->schema([
                                Select::make('section_id')
                                ->options(Section::whereHas('enrolled_sections')->get()->pluck('title', 'id'))
                                ->label('Section')
                                ->native(false)
                               ->columnSpan(4)
                                ->searchable(),
                            Select::make('teacher_id')
                                ->options(Teacher::whereHas('enrolled_sections')->get()->map(function($item){
                                    return [
                                        'id'=> $item->id,
                                        'fullname'=> $item?->user?->getFullName()
                                    ];
                                })->pluck('fullname', 'id'))
                                ->label('Teacher')
                                ->columnSpan(4)

            
                                ->native(false)
                                ->searchable()
                                ->hidden(function(){
                                    if(Auth::user()->isTeacher()){
                                        return true;
                                    }else{
                                        return false;
                                    }
                                })
                                ,
                            ])
                            
                            ,

                  
                   

                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['section_id'], fn (Builder $query) => $query->whereHas('student.enrolled_section', function($query) use($data){ 
                                $query->where('section_id', $data['section_id']);
                            }),
                        )

                        ->when(
                            $data['teacher_id'], fn (Builder $query) => $query->whereHas('student.enrolled_section', function($query) use($data){ 
                                $query->where('teacher_id', $data['teacher_id']);
                            }),
                        )
                        
                        ;
                }),

            ], layout: FiltersLayout::AboveContent)
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
                    ->modalWidth(MaxWidth::SevenExtraLarge)
                    ,
                    // ->url(function(Model $record){
                    //     return route('view-profile',['record'=> $record]);
                    // })
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
                // ->titlePrefixedWithLabel(false)
                
            ])
            ->filtersFormColumns(1)
            ->defaultGroup('student.enrolled_section.section.title')
            ;
    }

    public function render(): View
    {
        return view('livewire.exercise.list-taked-exam');
    }
}
