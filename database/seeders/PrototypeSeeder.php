<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Prototype;
use App\Models\Repository;
use App\Models\Technology;
use App\Models\Image;
use App\Models\ImageThumbnail;

class PrototypeSeeder extends Seeder
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

        Prototype::factory()
            ->count(5)
            ->has(Repository::factory()->count(5), 'repositories')
            ->has(Technology::factory()->count(5), 'technologies')
            ->hasAttached($images)
            ->create();
    }
}
