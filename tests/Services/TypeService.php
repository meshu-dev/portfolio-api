<?php

namespace Tests\Services;

use App\Models\Type;

class TypeService
{
    public function addType()
    {
        $type = Type::create([
            'name' => 'Development'
        ]);

        return $type;
    }

    public function addTypes(): array
    {
        $types = [
            Type::create([
                'name' => 'Production'
            ]),
            Type::create([
                'name' => 'Staging'
            ])
        ];

        return $types;
    }
}
