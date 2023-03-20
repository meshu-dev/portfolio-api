<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Prototype;
use App\Models\Type;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Prototype>
 */
class PrototypeFactory extends Factory
{
    protected $model = Prototype::class;

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
            'description' => fake()->text(200),
            'url' => fake()->url()
        ];
    }
}
