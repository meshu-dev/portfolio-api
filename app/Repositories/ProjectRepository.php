<?php

namespace App\Repositories;

use App\Models\Project;

class ProjectRepository extends UserRepository
{
    public function __construct(Project $project)
    {
        parent::__construct($project);
    }

    public function add(array $params)
    {
        $params['type_id'] = $params['type'];

        $project = parent::add($params);

        $project->repositories()->attach($params['repositories'] ?? []);
        $project->technologies()->attach($params['technologies'] ?? []);
        $project->images()->attach($params['images'] ?? []);
        $project->save();

        return $project ?? null;
    }

    public function getAll(int $userId, array $params)
    {
        $rowLimit = $params['per_page'] ?? self::ROW_LIMIT;

        $model = $this->model->where('user_id', $userId);

        if (isset($params['type_id']) === true) {
            $model->where('type_id', $params['type_id']);
        }        
        return $model->paginate($rowLimit);
    }

    public function edit(int $userId, int $id, array $params)
    {
        $updateParams = [
            'type_id'     => $params['type'],
            'name'        => $params['name'],
            'description' => $params['description'],
            'url'         => $params['url']
        ];

        $isEdited = parent::edit($userId, $id, $updateParams);
        $project  = $this->get($userId, $id);

        $project->repositories()->sync($params['repositories'] ?? []);
        $project->technologies()->sync($params['technologies'] ?? []);
        $project->images()->sync($params['images'] ?? []);
        $project->save();

        return $isEdited;
    }
}
