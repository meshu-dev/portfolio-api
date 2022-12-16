<?php

namespace Tests\Services;

class PortfolioService
{
    public function __construct(
        protected TypeService $typeService,
        protected RepositoryService $repositoryService,
        protected TechnologyService $technologyService,
        protected ImageService $imageService
    ) { }

    public function addRelatedData()
    {
        $type = $this->typeService->addType();
        $repositories = $this->repositoryService->addRepositories();
        $technologies = $this->technologyService->addTechnologies();
        $images = $this->imageService->addImages();

        return [
            'type' => $type,
            'repositories' => $repositories,
            'technologies' => $technologies,
            'images' => $images
        ];
    }

    protected function attachRepositories($model, $repositories)
    {
        foreach ($repositories as $repository) {
            $model->repositories()->attach($repository->id);
        }
    }

    protected function attachTechnologies($model, $technologies)
    {
        foreach ($technologies as $technology) {
            $model->technologies()->attach($technology->id);
        }
    }

    protected function attachImages($model, $images)
    {
        foreach ($images as $image) {
            $model->images()->attach($image->id);
        }
    }

    public function getRepositoryIds($repositories)
    {
        $ids = [];

        foreach ($repositories as $repository) {
            $ids[] = $repository->id;
        }
        return $ids;
    }

    public function getTechnologyIds($technologies)
    {
        $ids = [];

        foreach ($technologies as $technology) {
            $ids[] = $technology->id;
        }
        return $ids;
    }

    public function getImageIds($images)
    {
        $ids = [];

        foreach ($images as $image) {
            $ids[] = $image->id;
        }
        return $ids;
    }
}
