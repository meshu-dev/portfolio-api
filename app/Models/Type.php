<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Type extends BaseModel
{
    use HasFactory;

    protected $table = 'types';

    protected $fillable = ['user_id', 'name'];
}
