<?php
namespace App\Repositories;

use App\Models\Repository;

class RepositoryRepository extends ModelRepository
{
    public function __construct(Repository $repository)
    {
        parent::__construct($repository);
    }
}
