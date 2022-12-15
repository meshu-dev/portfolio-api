<?php
namespace App\Repositories;

use App\Models\Prototype;

class PrototypeRepository extends ModelRepository
{
    public function __construct(Prototype $prototype)
    {
        parent::__construct($prototype);
    }

    public function add($params)
    {
        $modelParams = [
            'type_id' => $params['typeId'],
            'name' => $params['name'],
            'description' => $params['description']
        ];
        $prototype = parent::add($modelParams);

        $prototype->repositories()->attach($params['repositoryIds'] ?? []);
        $prototype->technologies()->attach($params['technologyIds'] ?? []);
        $prototype->images()->attach($params['imageIds'] ?? []);

        return $prototype;
    }

    public function edit($id, $params)
    {
        $prototype = $this->get($id);

        $prototype->type_id = $params['typeId'];
        $prototype->name = $params['name'];
        $prototype->description = $params['description'];
        $prototype->save();

        $prototype->repositories()->sync($params['repositoryIds'] ?? []);
        $prototype->technologies()->sync($params['technologyIds'] ?? []);
        $prototype->images()->sync($params['imageIds'] ?? []);

        return $prototype;
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
        $prototype = $this->get($id);

        $prototype->repositories()->detach();
        $prototype->technologies()->detach();
        $prototype->images()->detach();

        return parent::delete($id);
    }
}
