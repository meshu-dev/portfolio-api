<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Technology extends BaseModel
{
    use HasFactory;

    protected $table = 'technologies';

    protected $fillable = ['name'];
}
