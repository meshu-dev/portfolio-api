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

        if ($projects->count() === 0 && $prototypes->count() === 0) {
            return false;
        }
        return true;
    }
}
