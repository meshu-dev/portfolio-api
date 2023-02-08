<?php

namespace Tests\Services;

use App\Models\Prototype;

class PrototypeService extends PortfolioService
{
    public function addPrototype()
    {
        return $this->createPrototype();
    }

    public function addPrototypes(): array
    {
        $prototypes = [
            $this->createPrototype(),
            $this->createPrototype()
        ];

        return $prototypes;
    }

    protected function createPrototype()
    {
        $type = $this->typeService->addType();

        $prototype = Prototype::create([
            'type_id' => $type->id,
            'name' => 'Prototype test app',
            'description' => 'Test Job Title'
        ]);

        $repositories = $this->repositoryService->addRepositories();

        foreach ($repositories as $repository) {
            $prototype->repositories()->attach($repository->id);
        }

        $technologies = $this->technologyService->addTechnologies();

        foreach ($technologies as $technology) {
            $prototype->technologies()->attach($technology->id);
        }

        return $prototype;
    }
}
