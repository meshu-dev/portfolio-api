<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'   => $this->id,
            'text' => $this->text,
            'employmentStartDate' => $this->employment_start_date,
            'years_experience' => $this->years_experience
        ];
    }
}
