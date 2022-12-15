<?php
namespace App\Services;

use App\Repositories\ProjectRepository;
use App\Repositories\PrototypeRepository;

class TypeService
{
    public function __construct(
        protected ProjectRepository $projectRepository,
        protected PrototypeRepository $prototypeRepository
    ) { }

    public function isUsed($typeId)
    {
        $projects = $this->projectRepository->getByType($typeId);
        $prototypes = $this->prototypeRepository->getByType($typeId);

        if ($projects->count() === 0 && $prototypes->count() === 0) {
            return false;
        }
        return true;
    }
}
