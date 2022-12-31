<?php
namespace App\Repositories;

use App\Models\Project;

class ProjectRepository extends ModelRepository
{
    public function __construct(Project $project)
    {
        parent::__construct($project);
    }

    public function add(array $params)
    {
        $modelParams = [
            'type_id' => $params['typeId'],
            'name' => $params['name'],
            'description' => $params['description']
        ];
        $project = parent::add($modelParams);

        $project->repositories()->attach($params['repositoryIds'] ?? []);
        $project->technologies()->attach($params['technologyIds'] ?? []);
        $project->images()->attach($params['imageIds'] ?? []);

        return $project;
    }

    public function edit($id, array $params)
    {
        $project = $this->get($id);

        $project->type_id = $params['typeId'];
        $project->name = $params['name'];
        $project->description = $params['description'];
        $project->save();

        $project->repositories()->sync($params['repositoryIds'] ?? []);
        $project->technologies()->sync($params['technologyIds'] ?? []);
        $project->images()->sync($params['imageIds'] ?? []);

        return $project;
    }

    public function getTypes()
    {
        $projects = $this->model
                         ->select('type_id')
                         ->groupBy('type_id')
                         ->get();

        $types = [];

        foreach ($projects as $project) {
            $types[] = $project->type;
        }
        return $types;
    }

    public function getByType($id)
    {
        return $this->model->where('type_id', $id)->get();
    }

    public function getByRepository($id)
    {
        return $this->model->whereRelation('repositories', 'repository_id', '=', $id)->get();
    }

    public function getByTechnology($id)
    {
        return $this->model->whereRelation('technologies', 'technology_id', '=', $id)->get();
    }

    public function getByImage($id)
    {
        return $this->model->whereRelation('images', 'image_id', '=', $id)->get();
    }

    public function delete($id)
    {
        $project = $this->get($id);

        $project->repositories()->detach();
        $project->technologies()->detach();
        $project->images()->detach();

        return parent::delete($id);
    }
}
