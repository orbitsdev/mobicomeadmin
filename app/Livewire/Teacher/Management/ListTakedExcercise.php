<?php

namespace App\Livewire\Teacher\Management;

use Filament\Tables;
use Livewire\Component;
use App\Models\TakedExam;
use Filament\Tables\Table;
use Filament\Tables\Grouping\Group;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
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
                Tables\Columns\TextColumn::make('excercise.title')
                  
                ->searchable(),
                TextColumn::make('student.user')->formatStateUsing(function ($state) {
                    return $state->getFullName();
                })
                    ->label('Student Name')
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->whereHas('student.user', function ($query) use ($search) {
                            $query->where('first_name', 'like', "%{$search}%")
                                ->orWhere('last_name', 'like', "%{$search}%");
                        });
                    }),
                 
              
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                    // ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable(),
                    // ->toggleable(isToggledHiddenByDefault: true),
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
                Group::make('excercise.title')
                    ->label('Exercise')
                    ->titlePrefixedWithLabel(false),
                    
            ])
            // ->default('excercise.title')
             ;
    }

    public function render(): View
    {
        return view('livewire.teacher.management.list-taked-excercise');
    }
}
