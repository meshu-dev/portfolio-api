<?php

namespace Tests\Services;

use App\Models\Repository;

class RepositoryService
{
    public function addRepository()
    {
        $repository = Repository::create([
            'name' => 'Development',
            'url' => 'http://prodbranch.com'
        ]);

        return $repository;
    }

    public function addRepositories(): array
    {
        $repositories = [
            Repository::create([
                'name' => 'Production',
                'url' => 'http://prodbranch.com'
            ]),
            Repository::create([
                'name' => 'Staging',
                'url' => 'http://stagbranch.com'
            ])
        ];

        return $repositories;
    }
}
