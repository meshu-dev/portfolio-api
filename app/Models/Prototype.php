<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prototype extends BaseModel
{
    use HasFactory;

    protected $table = 'prototypes';

    public function repositories()
    {
        return $this->belongsToMany(Repository::class, 'prototype_repositories', 'prototype_id', 'repository_id');
    }

    public function technologies()
    {
        return $this->belongsToMany(Technology::class, 'prototype_technologies', 'prototype_id', 'technology_id');
    }
}