<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\Repository;
use App\Models\Technology;
use App\Models\Image;
use App\Models\ImageThumbnail;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $images = Image::factory()
                    ->count(5)
                    ->has(ImageThumbnail::factory()->count(1))
                    ->create();

        Project::factory()
            ->count(5)
            ->has(Repository::factory()->count(5), 'repositories')
            ->has(Technology::factory()->count(5), 'technologies')
            ->hasAttached($images)
            ->create();
    }
}
