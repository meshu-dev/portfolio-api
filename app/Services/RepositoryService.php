<?php
namespace App\Services;

use App\Repositories\ProjectRepository;
use App\Repositories\PrototypeRepository;

class RepositoryService
{
    public function __construct(
        protected ProjectRepository $projectRepository,
        protected PrototypeRepository $prototypeRepository
    ) { }

    public function isUsed($repositoryId)
    {
        $projects = $this->projectRepository->getByRepository($repositoryId);
        $prototypes = $this->prototypeRepository->getByRepository($repositoryId); 

        if (empty($projects) === true && empty($prototypes) === true) {
            return false;
        }
        return true;
    }
}
