<?php

namespace App\Livewire\Sections;

use Filament\Tables;
use App\Models\Section;
use Livewire\Component;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Illuminate\Contracts\View\View;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class ListSections extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            ->query(Section::query())
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),

                ViewColumn::make('Enrolled Student')->view('tables.columns.teacher-total-student')
            ])
            ->filters([

            ])
            ->headerActions([


                    // ->slideOver()

            ])
        ->actions([
                Action::make('manage-section-student')
                    ->color('primary')
                    ->icon('heroicon-m-pencil-square')
                    ->label('Manage')
                    ->button()->outlined()
                 ->url(fn(Model $record)=> route('teacher-list-sections-users',['record'=> $record])),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //
                ]),
            ])
            ->modifyQueryUsing(fn (Builder $query) => $query->whereHas('enrolled_section.teacher.user', function ($query) {
                $query->where('id', auth()->user()->id);
            }))
            ;
    }

    public function render(): View
    {
        return view('livewire.sections.list-sections');
    }
}
