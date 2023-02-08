<?php

namespace App\Services;

use App\Repositories\ProjectRepository;
use App\Repositories\PrototypeRepository;

class ImageCheckService
{
    public function __construct(
        protected ProjectRepository $projectRepository,
        protected PrototypeRepository $prototypeRepository
    ) {
    }

    public function isUsed($imageId)
    {
        $projects = $this->projectRepository->getByTechnology($imageId);
        $prototypes = $this->prototypeRepository->getByTechnology($imageId);

        if ($projects->count() === 0 && $prototypes->count() === 0) {
            return false;
        }
        return true;
    }
}
