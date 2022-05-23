<?php
namespace App\Repositories;

use App\Models\Permission;

class PermissionRepository extends BaseRepository
{
    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return Permission::class;
    }
}
