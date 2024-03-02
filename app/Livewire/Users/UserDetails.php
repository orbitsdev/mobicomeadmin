<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;

class UserDetails extends Component
{   


    public  User $record;
    
    public function render()
    {
        return view('livewire.users.user-details');
    }
}
