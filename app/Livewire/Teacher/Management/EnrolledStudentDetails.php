<?php

namespace App\Livewire\Teacher\Management;

use App\Models\Student;
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

class EnrolledStudentDetails extends Component implements HasForms, HasInfolists
{

    use InteractsWithInfolists;
    use InteractsWithForms;
    public Student $record;


    public function userInfolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->record($this->record)
            ->schema([

            Tabs::make('Student Details')
        ->tabs([
            Tabs\Tab::make('Student Details')
                ->schema([

                    ViewEntry::make('_')
                    ->view('infolists.components.info-list-student-details'),


                ]),
            Tabs\Tab::make('Exercises')
                ->schema([
                    ViewEntry::make('__')
                    ->view('infolists.components.student-exercises-details'),

                ]),


            ])
            ->activeTab(2)

            ,


                // TextEntry::make('email'),

            ]);
    }
    public function render()
    {
        return view('livewire.teacher.management.enrolled-student-details');
    }
}
