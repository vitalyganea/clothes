<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $seederArray = [
            CategoriesAndSizesSeeder::class,
        ];

         User::firstOrCreate(['email' => 'zzzvitalii@gmail.com'], [
            'name' => 'Administrator',
            'email' => 'crm.admin@vebo.io',
            'email_verified_at' => now(),
            'password' => Hash::make('dinamic22'), // password
            'remember_token' => Str::random(10),
        ]);

        $this->call($seederArray);
    }
}
