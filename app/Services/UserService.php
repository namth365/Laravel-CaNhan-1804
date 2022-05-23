<?php

namespace App\Services;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Repositories\UserRepository;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function all()
    {
        return $this->userRepository->getAll();
    }

    public function search(Request $request)
    {
        if ($request['name'] != null || $request['email'] != null || $request['role_name'] != null) {
            return $this->userRepository->search($request);
        }
        return $this->userRepository->paginate(10);
    }

    public function findOrFail($id)
    {
        return $this->userRepository->findOrFail($id);
    }

    public function create(StoreUserRequest $request)
    {
        $dataCreate = $request->all();
        if (isset($dataCreate['password'])) {
            $dataCreate['password'] = Hash::make($dataCreate['password']);
        }
        $user = $this->userRepository->create($dataCreate);
        if (isset($request->role)) {
            if (!empty($request->role)) {
                $user->roles()->attach($dataCreate['role']);
            }
            return $user;
        } else {
            $role = Role::where('name', 'new member')->first();
            $user->roles()->attach($role->id);
        }
    }

    public function update($id, UpdateUserRequest $request)
    {
        $dataUpdate['name'] = $request->name;
        if (isset($request->password)) {
            $dataUpdate['password'] = Hash::make($request->password);
        }
        $user = $this->userRepository->update($dataUpdate, $id);
        if (isset($request->role)) {
            if (!empty($request->role)) {
                $user->roles()->sync($request->role);
            } else {
                $user->roles()->detach();
            }
            return $user;
        }
    }

    public function delete($id)
    {
        $this->userRepository->delete($id);
    }

    public function createRegister(array $request)
    {
        $dataCreate =
            [
                'name' => $request['name'],
                'password' => Hash::make($request['password']),
                'email' => $request['email']
            ];
        $user = $this->userRepository->create($dataCreate);
        $role = Role::where('name', 'new member')->first();
        $user->roles()->attach($role->id);
    }
}
