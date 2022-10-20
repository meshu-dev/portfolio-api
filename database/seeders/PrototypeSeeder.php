<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Prototype;
use App\Models\Repository;
use App\Models\Technology;

class PrototypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Prototype::factory()
            ->count(5)
            ->has(Repository::factory()->count(5), 'repositories')
            ->has(Technology::factory()->count(5), 'technologies')
            ->create();
    }
}
