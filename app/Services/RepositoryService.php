<?php

namespace App\Services;

use App\Repositories\ProjectRepository;
use App\Repositories\PrototypeRepository;

class RepositoryService
{
    public function __construct(
        protected ProjectRepository $projectRepository,
        protected PrototypeRepository $prototypeRepository
    ) {
    }

    public function isUsed($repositoryId)
    {
        $projects = $this->projectRepository->getByRepository($repositoryId);
        $prototypes = $this->prototypeRepository->getByRepository($repositoryId);

        if ($projects->count() === 0 && $prototypes->count() === 0) {
            return false;
        }
        return true;
    }
}
