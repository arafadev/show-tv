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
         User::create([
            'name' => 'Ahmed Arafa',
            'email' => 'arafa.dev@gmail.com',
            'password' => Hash::make('123456789'),
        ]);

        User::create([
            'name' => 'Mohamed Arafa',
            'email' => 'mohamedarafa@gmail.com',
            'password' => Hash::make('123456789'),
        ]);

        User::create([
            'name' => 'ebrahim Arafa',
            'email' => 'ebrahimarafa@gmail.com',
            'password' => Hash::make('123456789'),
        ]);

        User::factory(10)->create();
    }
}
