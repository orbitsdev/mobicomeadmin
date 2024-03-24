<?php

namespace App\Livewire\Sections;

use Filament\Tables;
use App\Models\Section;
use Livewire\Component;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Concerns\InteractsWithTable;

class ListSection extends Component implements HasForms, HasTable
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
             
            ])
            ->filters([
                //
            ])

            ->headerActions([

                CreateAction::make()
                    ->color('primary')
                    ->icon('heroicon-m-sparkles')
                    ->label('New Section')
                    ->form([
                        TextInput::make('title')
                            ->required()
                            
                       
                    ])
                    


            ])
            ->actions([
                            EditAction::make('edit')
                            ->form([
                                TextInput::make('title')
                                    ->required()
                                    
                                // ...
                            ])
                            ,
                            DeleteAction::make('delete'),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([


                    BulkAction::make('delete')
                        ->requiresConfirmation()
                        ->action(fn (Collection $records) => $records->each->delete())
                ])
                ->label('Actions')
                ,
            ]);
    }

    public function render(): View
    {
        return view('livewire.sections.list-section');
    }
}
