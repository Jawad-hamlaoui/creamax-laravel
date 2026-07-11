<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database. Le compte admin est créé séparément
     * via `php artisan make:filament-user`, pas ici (mot de passe réel requis).
     */
    public function run(): void
    {
        $this->call([
            SettingSeeder::class,
            PrestationSeeder::class,
        ]);
    }
}
