<?php
namespace App\Repositories;

use App\Models\Prototype;

class PrototypeRepository extends ModelRepository
{
    public function __construct(Prototype $prototype)
    {
        parent::__construct($prototype);
    }
}
