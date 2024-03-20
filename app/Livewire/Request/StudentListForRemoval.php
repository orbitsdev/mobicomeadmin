<?php

namespace App\Livewire\Request;

use Filament\Tables;
use App\Models\Student;
use App\Models\Teacher;
use Livewire\Component;
use Filament\Tables\Table;
use App\Models\Section as MSection;
use Illuminate\Contracts\View\View;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class StudentListForRemoval extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(Student::query())
            ->columns([
                TextColumn::make('user')->formatStateUsing(function ($state) {
                    return $state->getFullName();
                })
                    ->label('Student Name')
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->whereHas('user', function ($query) use ($search) {
                            $query->where('first_name', 'like', "%{$search}%")
                                ->orWhere('last_name', 'like', "%{$search}%");
                        });
                    }),
                TextColumn::make('user.email')->searchable()->label('Email'),

                TextColumn::make('enrolled_section.teacher.user')
                    ->formatStateUsing(function ($state) {
                        return $state->getFullName();
                    })
                    ->label('Teacher')
                    ->badge(),
                TextColumn::make('enrolled_section.section.title')
                    ->label('Section')
                    ->badge()
                    ->searchable(),
                TextColumn::make('remove_request.message')
                    ->label('Message')
            ])
            ->filters([
                SelectFilter::make('sections')
                ->options(fn () => MSection::whereHas('enrolled_sections')->pluck('title', 'id')) //you probably want to limit this in some way?
                ->modifyQueryUsing(function (Builder $query, $state) {
                    if (!$state['value']) {
                        return $query;
                    }
                    return $query->whereHas('enrolled_section', fn ($query) => $query->where('section_id', $state['value']));
                }),
            SelectFilter::make('teacher')
                ->options(fn () => Teacher::whereHas('enrolled_sections.teacher')->get()->map(function($item){
                    return [

                        'full_name'=> $item->user->getFullName(),
                        'id'=> $item->id,


                    ];
                })->pluck('full_name', 'id')) //you probably want to limit this in some way?
                ->modifyQueryUsing(function (Builder $query, $state) {
                    if (!$state['value']) {
                        return $query;  
                    }
                    return $query->whereHas('enrolled_section', fn ($query) => $query->where('teacher_id', $state['value']));
                }),
            ],  layout: FiltersLayout::AboveContent
                
            )
            ->actions([
                DeleteAction::make('delete')->label('Remove')
                ->modalHeading('Remove Student')
                ->modalDescription('Are you sure you\'d like to remove this student? This cannot be undone.')
                ->modalSubmitActionLabel('Yes, Remove it')
                ,
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //
                ]),
            ])
            ->poll('3')
            ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('remove_request'));
            
    }

    public function render(): View
    {
        return view('livewire.request.student-list-for-removal');
    }
}
