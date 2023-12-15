<?php

namespace App\Repositories;

use App\Contracts\Repository;
use Illuminate\Database\Eloquent\Model;

/**
 * Used to perform CRUD operations.
 */
abstract class UserRepository
{
    protected const ROW_LIMIT = 1000;

    protected $model;

    /**
     * Constructor for class.
     *
     * @param Model $model Used to get and set data.
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Create data entry from array to JSON.
     *
     * @param array $params The parameteres for data entry.
     *
     * @return array|null
     */
    public function add(array $params)
    {
        $row = $this->model->create($params);

        if (empty($row) === false) {
            return $row;
        }
        return null;
    }

    /**
     * Read data entry from given ID.
     *
     * @param mixed $id The ID for specific data entry.
     *
     * @return array|null
     */
    public function get(int $userId, int $id)
    {
        $row = $this->model
                    ->where('user_id', $userId)
                    ->where('id', $id)
                    ->first();

        if (empty($row) === false) {
            return $row;
        }
        return null;
    }

    /**
     * Read all data entries to an array.
     *
     * @param array $params Used to filter data entries.
     *
     * @return array
     */
    public function getAll(int $userId, array $params)
    {
        $rowLimit = $params['per_page'] ?? self::ROW_LIMIT;

        return $this->model
                    ->where('user_id', $userId)
                    ->paginate($rowLimit);
    }

    /**
     * Update existing data entry from given ID.
     *
     * @param mixed $id The ID for specific data entry.
     * @param array $params Parameters used to update data entry.
     *
     * @return array|null
     */
    public function edit(int $userId, int $id, array $params)
    {
        $isEdited = $this->model
                         ->where('user_id', $userId)
                         ->where('id', $id)
                         ->update($params);

        return $isEdited;
    }

    /**
     * Delete existing data entry from given ID.
     *
     * @param mixed $id The ID for specific data entry.
     *
     * @return void
     */
    public function delete(int $userId, int $id)
    {
        return $this->model
                    ->where('user_id', $userId)
                    ->where('id', $id)
                    ->delete();
    }
}
