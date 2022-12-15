<?php
namespace App\Services;

use App\Repositories\ProjectRepository;
use App\Repositories\PrototypeRepository;

class ImageCheckService
{
    public function __construct(
        protected ProjectRepository $projectRepository,
        protected PrototypeRepository $prototypeRepository
    ) { }

    public function isUsed($imageId)
    {
        $projects = $this->projectRepository->getByTechnology($imageId);
        $prototypes = $this->prototypeRepository->getByTechnology($imageId); 

        if (empty($projects) === true && empty($prototypes) === true) {
            return false;
        }
        return true;
    }
}
