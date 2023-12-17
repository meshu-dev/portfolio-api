<?php

namespace App\Repositories;

use App\Models\Profile;

class ProfileRepository extends UserRepository
{
    public function __construct(Profile $profile)
    {
        parent::__construct($profile);
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
