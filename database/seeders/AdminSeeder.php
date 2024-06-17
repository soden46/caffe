<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::create([

            'nama' => 'admin',
            'email' => 'admin@admin.com',
            'role' => 'admin',
            'email_verified_at' => now(),
            'password' => Hash::make("admin"), // password
            'remember_token' => Str::random(10),
        ]);
        User::create([
            'nama' => 'user',
            'email' => 'user@user.com',
            'role' => 'user',
            'email_verified_at' => now(),
            'password' => Hash::make("user"), // password
            'remember_token' => Str::random(10),
        ]);
    }
}
