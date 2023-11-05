<?php

namespace App\Repositories;

use App\Models\Technology;

class TechnologyRepository extends ModelRepository
{
    public function __construct(Technology $technology)
    {
        parent::__construct($technology);
    }
}
