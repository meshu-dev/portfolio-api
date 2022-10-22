<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends BaseModel
{
    use HasFactory;

    protected $table = 'images';

    protected $fillable = ['url'];

    public function imageThumbnail()
    {
        return $this->hasOne(ImageThumbnail::class, 'image_id', 'id');
    }
}
