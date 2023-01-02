<?php
namespace App\Repositories;

use App\Models\About;

class AboutRepository extends ModelRepository
{
    public function __construct(About $about)
    {
        parent::__construct($about);
    }
}
