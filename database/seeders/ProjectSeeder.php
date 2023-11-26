<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{
    User,
    Project,
    Repository,
    Technology,
    Image,
    ImageThumbnail
};

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user      = User::firstOrFail();
        $params    = ['user_id' => $user->id];
        $itemCount = 5;

        $images = Image::factory($params)
                    ->count($itemCount)
                    ->has(ImageThumbnail::factory()->count(1))
                    ->create();

        Project::factory($params)
            ->count($itemCount)
            ->has(Repository::factory($params)->count($itemCount), 'repositories')
            ->has(Technology::factory($params)->count($itemCount), 'technologies')
            ->hasAttached($images)
            ->create();
    }
}
