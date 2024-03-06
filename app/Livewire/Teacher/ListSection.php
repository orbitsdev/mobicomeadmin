<?php

namespace App\Livewire\Teacher;

use Filament\Tables;
use App\Models\Section;
use App\Models\Teacher;
use Livewire\Component;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Illuminate\Contracts\View\View;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class ListSection extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public Teacher $record;
    public function table(Table $table): Table
    {
        return $table
            ->query(Section::query())
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),

                    ViewColumn::make('Enrolled Student')->view('tables.columns.teacher-total-student')
                // TextColumn::make('enrolled_sections_count')->counts('enrolled_sections')

            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('manage-section-student')
                ->color('primary')
                ->icon('heroicon-m-pencil-square')
                ->label('Manage')
                ->button()->outlined()
                ->url(fn(Model $record)=> route('list-teacher-section-students',['record'=> $record])),
                // DeleteAction::make('delete'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //
                ]),
            ])
            ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('enrolled_section.teacher', function($query){
                $query->where('id',$this->record->id);
            }))
            ;
    }

    public function render(): View
    {
        return view('livewire.teacher.list-section');
    }
}
