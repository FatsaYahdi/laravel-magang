<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        User::factory()->create([
            'name' => 'superadmin',
            'email' => 'superadmin@gmail.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'birth' => now()->toDateTimeString(),
            'gender' => 'secret',
            'role' => 'superadmin',
            'pp' => "",
            'address' => '',
            'status' => 'active'
        ]);
    }
}

// 'name',
// 'email',
// 'password',
// 'birth',
// 'gender',
// 'role',
// 'pp',
// 'address'