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

        if (empty($projects) === true && empty($prototypes) === true) {
            return false;
        }
        return true;
    }
}
