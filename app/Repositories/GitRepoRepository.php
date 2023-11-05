<?php

namespace App\Repositories;

use App\Models\GitRepo;

class GitRepoRepository extends ModelRepository
{
    public function __construct(GitRepo $gitRepo)
    {
        parent::__construct($gitRepo);
    }
}
