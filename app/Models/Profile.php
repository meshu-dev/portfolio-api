<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Profile extends BaseModel
{
    use HasFactory;

    protected $table = 'profiles';

    protected $fillable = ['user_id', 'text', 'employment_start_date'];

    public function getYearsExperienceAttribute()
    {
        $yearsExperienceDate = Carbon::createFromFormat('Y-m-d',  $this->employment_start_date);
        $currentDate = Carbon::now();

        $diffInDays = $yearsExperienceDate->diffInDays($currentDate);

        return floor($diffInDays / 365);
    }
}
