<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Repository extends BaseModel
{
    use HasFactory;

    protected $table = 'repositories';

    protected $fillable = ['user_id', 'name', 'url'];
}
