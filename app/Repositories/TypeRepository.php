<?php
namespace App\Repositories;

use App\Models\Type;

class TypeRepository extends ModelRepository
{
    public function __construct(Type $type)
    {
        parent::__construct($type);
    }
}
