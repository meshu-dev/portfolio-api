<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends BaseModel
{
    use HasFactory;

    protected $table = 'projects';

    public function repositories()
    {
        return $this->belongsToMany(Repository::class, 'project_repositories', 'project_id', 'repository_id');
    }

    public function technologies()
    {
        return $this->belongsToMany(Technology::class, 'project_technologies', 'project_id', 'technology_id');
    }

    public function images()
    {
        return $this->belongsToMany(Image::class, 'project_images', 'project_id', 'image_id');
    }
}
