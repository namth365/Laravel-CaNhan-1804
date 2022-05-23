<?php

namespace App\Repositories;

use App\Models\Role;

class RoleRepository extends BaseRepository
{
    public function getModel()
    {
        return Role::class;
    }

    public function search($dataSearch)
    {
        return $this->model->withName($dataSearch['name'])
                           ->paginate(5);
    }
}
