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

        $project->repositories()->attach($params['repositoryIds']);
        $project->technologies()->attach($params['technologyIds']);
        $project->images()->attach($params['imageIds']);

        return $project;
    }

    public function edit($id, array $params)
    {
        $project = $this->get($id);

        $project->type_id = $params['typeId'];
        $project->name = $params['name'];
        $project->description = $params['description'];
        $project->save();

        $project->repositories()->sync($params['repositoryIds']);
        $project->technologies()->sync($params['technologyIds']);
        $project->images()->sync($params['imageIds']);

        return $project;
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
