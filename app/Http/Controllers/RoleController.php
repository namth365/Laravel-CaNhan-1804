<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Services\PermissionService;
use App\Services\RoleService;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    protected $roleService;
    protected $permissionService;

    public function __construct(RoleService $roleService, PermissionService $permissionService)
    {
        $this->roleService = $roleService;
        $this->permissionService = $permissionService;
    }

    public function index(Request $request)
    {
        $roles = $this->roleService->search($request);

        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = $this->permissionService->all();

        return view('roles.create', compact('permissions'));
    }

    public function store(StoreRoleRequest $request)
    {
        $this->roleService->create($request);

        return redirect(route('roles.index'))->with('messenger', 'Create Role Success !');
    }

    public function edit($id)
    {
        $role = $this->roleService->findOrFail($id);
        $permissions = $this->permissionService->all();

        return view('roles.edit', compact('role', 'permissions'));
    }

    public function update(UpdateRoleRequest $request, $id)
    {
        $this->roleService->update($request, $id);

        return redirect(route('roles.index'))->with('messenger', 'Update Role Success !');
    }

    public function destroy($id)
    {
        $this->roleService->delete($id);

        return redirect(route('roles.index'))->with('messenger', 'Delete Role Success !');
    }
}
