<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Hardcoded data seeder
        $this->call([
            UserSeeder::class,
            DataSeeder::class
        ]);


        // Randomly generated data seeders
        /*
        $this->call([
            UserSeeder::class,
            TypeSeeder::class,
            ProjectSeeder::class,
            ProfileSeeder::class
        ]); */
    }
}
