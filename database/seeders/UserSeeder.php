<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin_user = User::create([
            'first_name'=> 'Admin ',
            'last_name'=> 'User',
            'email'=> 'admin@gmail.com',
            'role'=> 'Admin',
            'password'=> Hash::make('password'),
        ]);
        $teacher_user = User::create([
            'first_name'=> 'Teacher ',
            'last_name'=> 'User',
            'email'=> 'teacher@gmail.com',
            'role'=> 'Teacher',
            'password'=> Hash::make('password'),
        ]);
        $teacher_user1 = User::create([
            'first_name'=> 'Teacher2 ',
            'last_name'=> 'User',
            'email'=> 'teacher2@gmail.com',
            'role'=> 'Teacher',
            'password'=> Hash::make('password'),
        ]);
        $studer_user = User::create([
            'first_name'=> 'Student ',
            'last_name'=> 'User',
            'email'=> 'Student@gmail.com',
            'role'=> 'Student',
            'password'=> Hash::make('password'),
        ]);
    }
}
