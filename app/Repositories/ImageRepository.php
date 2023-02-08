<?php

namespace App\Repositories;

use App\Models\Image;

class ImageRepository extends ModelRepository
{
    public function __construct(Image $image)
    {
        parent::__construct($image);
    }
}
