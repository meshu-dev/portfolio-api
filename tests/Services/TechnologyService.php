<?php

namespace Tests\Services;

use App\Models\Technology;

class TechnologyService
{
    public function addTechnology()
    {
        $technology = Technology::create([
            'name' => 'Development'
        ]);

        return $technology;
    }

    public function addTechnologies(): array
    {
        $technologies = [
            Technology::create([
                'name' => 'Production'
            ]),
            Technology::create([
                'name' => 'Staging'
            ])
        ];

        return $technologies;
    }
}
