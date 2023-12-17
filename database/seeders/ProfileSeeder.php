<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{User, Profile};

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::firstOrFail();

        Profile::factory(['user_id' => $user->id])->create();
    }
}
