<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ImageThumbnail;
use App\Models\Image;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ImageThumbnail>
 */
class ImageThumbnailFactory extends Factory
{
    protected $model = ImageThumbnail::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'image_id' => Image::all()->random()->id,
            'url' => fake()->imageUrl()
        ];
    }
}
