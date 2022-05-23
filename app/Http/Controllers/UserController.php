<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Services\RoleService;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;
    protected $roleService;

    public function __construct(UserService $userService, RoleService $roleService)
    {
        $this->userService = $userService;
        $this->roleService = $roleService;
    }

    public function index(Request $request)
    {
        $users = $this->userService->search($request);
        $roles = $this->roleService->all();

        return view('users.index', compact('users', 'roles'));
    }

    public function create()
    {
        $role = $this->roleService->all();

        return view('users.create', compact('role'));
    }

    public function store(StoreUserRequest $request)
    {
        $this->userService->create($request);

        return redirect(route('users.index'))->with('messenger', 'Create User Success !');
    }

    public function edit(int $id)
    {
        $users = $this->userService->findOrFail($id);
        $roles = $this->roleService->all();

        return view('users.edit', compact('users', 'roles'));
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $this->userService->update($id, $request);

        return redirect(route('users.index'))->with('messenger', 'Update User Success !');
    }

    public function destroy($id)
    {
        $this->userService->delete($id);

        return redirect(route('users.index'))->with('messenger', 'Delete User Success !');
    }
}
