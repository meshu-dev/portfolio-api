<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Project;
use App\Models\Type;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    protected $model = Project::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $typeIds = Type::all()->pluck('id');

        return [
            'type_id' => fake()->randomElement($typeIds),
            'name' => fake()->company(),
            'description' => fake()->text(200)
        ];
    }
}
