<?php
namespace App\Repositories;

use App\Models\ImageThumbnail;

class ImageThumbnailRepository extends ModelRepository
{
    public function __construct(ImageThumbnail $image)
    {
        parent::__construct($image);
    }

    public function deleteByImageId($imageId)
    {
        return $this->model->where('image_id', $imageId)->delete();
    }
}
