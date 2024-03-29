<?php

namespace App\Livewire\Users;

use App\Models\User;
use App\Models\Student;
use Livewire\Component;
use Filament\Infolists\Infolist;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Components\Tabs;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Infolists\Concerns\InteractsWithInfolists;

class UserDetails extends Component implements HasForms, HasInfolists
{

    use InteractsWithInfolists;
    use InteractsWithForms;
    public User $record;


    // public function mount(Student $record){

    //     $this->record = $record;

    //     dd($this->record);
    // }


    public function userInfolist(Infolist $infolist): Infolist
{
    return $infolist
        ->record($this->record)
        ->schema([

            Tabs::make('S')
    ->tabs([
        Tabs\Tab::make('Tab 1')
            ->schema([
                // ...
            ]),
        Tabs\Tab::make('Tab 2')
            ->schema([
                // ...
            ]),
        Tabs\Tab::make('Tab 3')
            ->schema([
                // ...
            ]),
        ]),

            ViewEntry::make('_')
    ->view('infolists.components.info-list-student-details'),
            // TextEntry::make('email'),

        ]);
}
    public function render()
    {
        return view('livewire.users.user-details');
    }
}
