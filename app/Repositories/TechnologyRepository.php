<?php

namespace App\Repositories;

use App\Models\Technology;

class TechnologyRepository extends UserRepository
{
    public function __construct(Technology $technology)
    {
        parent::__construct($technology);
    }
}
