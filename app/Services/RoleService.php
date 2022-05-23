<?php

namespace App\Services;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Role_Permission;
use App\Repositories\RoleRepository;
use Illuminate\Http\Request;

class RoleService
{
    /**
     * @var $roleRepository
     */
    protected $roleRepository;

    /**
     * PostService constructor.
     *
     * @param RoleRepository $roleRepository;
     */
    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }
    /**
     * Get All post
     * @return String
     */

    public function all()
    {
        return $this->roleRepository->getAll();
    }

    public function search(Request $request)
    {
        if ($request['name'] != null) {
            return $this->roleRepository->search($request);
        }
        return $this->roleRepository->paginate(5);
    }

    public function findOrFail($id)
    {
        return $this->roleRepository->findOrFail($id);
    }

    public function create(StoreRoleRequest $request)
    {
        $dataCreate = $request->all();
        $role =  $this->roleRepository->create($dataCreate);
        if (!empty($request->permission)) {
            $role->permissions()->attach($dataCreate['permission']);
        }
        return $role;
    }

    public function update(UpdateRoleRequest $request, $id)
    {
        $dataUpdate = $request->all();
        $role =  $this->roleRepository->update($dataUpdate, $id);
        if (!empty($request->permission)) {
            $role->permissions()->sync($dataUpdate['permission']);
        } else {
            $role->permissions()->detach();
        }
        return $role;
    }

    public function delete($id)
    {
        $this->roleRepository->delete($id);
    }
}
