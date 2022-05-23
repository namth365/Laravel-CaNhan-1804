<?php

namespace App\Services;

use App\Repositories\PermissionRepository;

class PermissionService
{
    protected PermissionRepository $permissionRepository;

    public function __construct(
        PermissionRepository $permissionRepository
    ) {
        $this->permissionRepository = $permissionRepository;
    }

    public function all()
    {
        return $this->permissionRepository->getAll();
    }
}
