<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@elrahma.ac.id'],
            [
                'name'     => 'Admin Perpustakaan',
                'password' => bcrypt('admin12345'),
            ]
        );
    }
}