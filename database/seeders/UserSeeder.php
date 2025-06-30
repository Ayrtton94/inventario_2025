<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::Create([
            'name'=>'Admin',
            'email'=>'admin@admin.com',
            'password'=>bcrypt('12345678')
        ])->assignRole('Admin');

        User::Create([
            'name'=>'Tecnico',
            'email'=>'tecnico@tecnico.com',
            'password'=>bcrypt('12345678')
        ])->assignRole('Tecnico');

         User::Create([
            'name'=>'Tecnico2',
            'email'=>'tecnico2@tecnico.com',
            'password'=>bcrypt('12345678')
        ]);

        User::factory(10)->create();
    }
}
