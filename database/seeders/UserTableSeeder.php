<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $exist = User::where('email', 'admin@gmail.com')->count();
        if(!$exist) {
            User::create([
                'name' => 'Admin',
                'role' => 'superadmin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('12345678')
            ]);
        }
    }
}
