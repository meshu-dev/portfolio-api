<?php

namespace App\Repositories;

use App\Models\About;

class AboutRepository extends UserRepository
{
    public function __construct(About $about)
    {
        parent::__construct($about);
    }

    public function getByUserId(int $userId)
    {
        $row = $this->model->where('user_id', $userId)->first();

        if (empty($row) === false) {
            return $row;
        }
        return null;
    }

    public function editByUserId(int $userId, array $params)
    {
        $row = $this->model->where('user_id', '=', $userId)->update($params);

        if (empty($row) === false) {
            return $row;
        }
        return null;
    }
}
