<?php

namespace Tests\Services;

use App\Models\Image;
use App\Models\ImageThumbnail;

class ImageService
{
    public function addImage()
    {
        return $this->createImage();
    }

    public function addImages(): array
    {
        $images = [
            $this->createImage(),
            $this->createImage()
        ];

        return $images;
    }

    protected function createImage()
    {
        $image = Image::create([
            'url' => 'https://via.placeholder.com/640x480.png/006699?text=nihil'
        ]);

        $imageThumbnail = ImageThumbnail::create([
            'image_id' => $image->id,
            'url' => 'https://via.placeholder.com/640x480.png/003366?text=possimus'
        ]);

        return $image;
    }
}
