<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        User::create([
            'name' => 'Admin GisMap',
            'email' => 'admin@gismap.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password@gismap.com'), // password
            'remember_token' => Str::random(10),
        ]);

    }
}
