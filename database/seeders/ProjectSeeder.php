<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\Repository;
use App\Models\Technology;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Project::factory()
            ->count(5)
            ->has(Repository::factory()->count(5), 'repositories')
            ->has(Technology::factory()->count(5), 'technologies')
            ->create();
    }
}
