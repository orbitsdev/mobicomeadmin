<?php

namespace App\Livewire\Teacher;

use App\Models\Teacher;
use Livewire\Component;


use Illuminate\Support\Carbon;
use Filament\Infolists\Infolist;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Components\Tabs;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Infolists\Concerns\InteractsWithInfolists;

class TeacherDetails extends Component implements HasForms, HasInfolists
{   
    use InteractsWithInfolists;
    use InteractsWithForms;
    public Teacher $record;

    public function recordInfolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->record($this->record)
            ->schema([

            Tabs::make('Teacher Details')
        ->tabs([
            Tabs\Tab::make('Teacher Details')
                ->schema([

                    ViewEntry::make('_')
                    ->view('infolists.components.teacher-details'),


                ]),
            // Tabs\Tab::make('Sections')
            //     ->schema([
                
            //         ViewEntry::make('__')
            //         ->view('infolists.components.teacher-section-entry'),
            //     ]),
            Tabs\Tab::make('Sections')
                ->schema([
                    

                    ViewEntry::make('__')
                    ->view('infolists.components.list-studen-entry'),

                ]),
            Tabs\Tab::make('Created Exercises')
                ->schema([
                    ViewEntry::make('___')
                    ->view('infolists.components.teacher-exercises-entry'),

                ]),


            ])
            ->activeTab(3)
        

            


                

            ]);
    }
    public function render()
    {
        return view('livewire.teacher.teacher-details');
    }
}
