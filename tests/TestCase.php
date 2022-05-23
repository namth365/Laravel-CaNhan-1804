<?php

namespace Tests;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, WithFaker;

    public function login($roleName, $user = null)
    {
        $user = $user ?? User::factory()->create();
        $roleIds = Role::whereIn('name', $roleName)->pluck('id')->toArray();
        $user->roles()->sync($roleIds);
        $this->actingAs($user);
        return $user;
    }
}
