<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends BaseRepository
{
    public function getModel()
    {
        return User::class;
    }

    public function search($dataSearch)
    {
        return $this->model->withRoleName($dataSearch['role_name'])
            ->withName($dataSearch['name'])
            ->withEmail($dataSearch['email'])
            ->paginate(5);
    }
}
