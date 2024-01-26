<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        DB::table('admins')->insert([
            'admin_name' => 'Kaushal',
            'username' => 'kaushal',
            'email' => 'kaushalnishad212@gmail.com',
            'password' => Hash::make('123456')
        ]);

        DB::table('settings')->insert([
            'site_name' => 'Laravel Quiz App',
            'site_title' => 'Laravel Quiz App',
        ]);
    }
}
