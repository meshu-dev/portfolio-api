<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class ImageThumbnail extends BaseModel
{
    use HasFactory;

    protected $table = 'image_thumbnails';

    protected $fillable = ['image_id', 'url'];
}
