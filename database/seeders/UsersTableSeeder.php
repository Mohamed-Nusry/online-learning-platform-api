<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create(
            [
                'first_name' => 'Institute',
                'last_name' => 'Staff',
                'username' => 'institute',
                'email' => 'institute@lp.com',
                'password' => Hash::make('institute@lp'),
                'type' => 'ADMIN',
                'email_verified_at' => now(),
            ]
        );

        $user = User::create(
            [
                'first_name' => 'Mark',
                'last_name' => 'William',
                'username' => 'mark',
                'email' => 'mark@gmail.com',
                'password' => Hash::make('mark12345'),
                'type' => 'STUDENT',
                'email_verified_at' => now(),
            ]
        );
    }
}
