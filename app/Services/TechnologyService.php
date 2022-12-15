<?php
namespace App\Services;

use App\Repositories\ProjectRepository;
use App\Repositories\PrototypeRepository;

class TechnologyService
{
    public function __construct(
        protected ProjectRepository $projectRepository,
        protected PrototypeRepository $prototypeRepository
    ) { }

    public function isUsed($technologyId)
    {
        $projects = $this->projectRepository->getByTechnology($technologyId);
        $prototypes = $this->prototypeRepository->getByTechnology($technologyId); 

        if (empty($projects) === true && empty($prototypes) === true) {
            return false;
        }
        return true;
    }
}
