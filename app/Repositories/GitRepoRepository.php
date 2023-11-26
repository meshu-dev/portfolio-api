<?php

namespace App\Repositories;

use App\Models\Repository;

class GitRepoRepository extends UserRepository
{
    public function __construct(Repository $repository)
    {
        parent::__construct($repository);
    }
}
