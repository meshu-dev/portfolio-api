<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{User, Type};

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::firstOrFail();

        Type::factory(['user_id' => $user->id])
            ->count(5)
            ->create();
    }
}
