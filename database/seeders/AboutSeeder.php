<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{User, About};

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::firstOrFail();

        About::factory(['user_id' => $user->id])->create();
    }
}
