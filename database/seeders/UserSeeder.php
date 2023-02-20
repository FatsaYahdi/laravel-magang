<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->superadmin()->count(1)->create([
            'name' => 'superadmin',
            'email' => 'superadmin@gmail.com'
        ]);
        User::factory()->count(50)->create();
    }
}
