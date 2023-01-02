<?php
namespace App\Repositories;

use App\Interfaces\Repository;
use Illuminate\Database\Eloquent\Model;

/**
 * Used to perform CRUD operations.
 */
abstract class ModelRepository implements Repository
{
    private const ROW_LIMIT = 10;

    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function add(array $params)
    {
        $row = $this->model->create($params);

        if (empty($row) === false) {
            return $row;
        }
        return null;
    }

    public function get($id)
    {
        $row = $this->model->find($id);

        if (empty($row) === false) {
            return $row;
        }
        return null;
    }

    public function getAll(array $params = [])
    {
        $params = $this->model->verifySearchable($params);
        
        if (isset($params['offset']) === true) {
            $offset = (int) $params['offset'];
            unset($params['offset']);
        } else {
            $offset = 0;
        }

        if (isset($params['limit']) === true) {
            $limit = (int) $params['limit'];
            unset($params['limit']);
        } else {
            $limit = self::ROW_LIMIT;
        }

        if (isset($params['order']) === true) {
            $orderField = key($params['order']);
            $sort = current($params['order']);
            unset($params['order']);
        } else {
            $orderField = 'id';
            $sort = 'desc';
        }

        $rows = $this->model
            ->where($params)
            ->skip($offset)
            ->take($limit)
            ->orderBy($orderField, $sort)
            ->get();

        if (empty($rows) === false) {
            return $rows;
        }
        return null;
    }

    public function edit($id, array $params)
    {
        $row = $this->model->where('id', '=', $id)->update($params);

        if (empty($row) === false) {
            return $row;
        }
        return null;
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    public function getTotal(array $params = [])
    {
        $params = $this->model->verifySearchable($params);
        
        if (isset($params['offset']) === true) {
            unset($params['offset']);
        }
        
        if (isset($params['limit']) === true) {
            unset($params['limit']);
        }

        if (isset($params['order']) === true) {
            unset($params['order']);
        }

        return $this->model->where($params)->count();
    }

    public function getPagination($limit = null)
    {
        if ($limit === null) {
            $limit = self::ROW_LIMIT;
        }
        return $this->model->paginate($limit);
    }
}
