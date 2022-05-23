<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = "roles";

    protected $fillable = ['type','name'];

    public function user()
    {
        return $this->belongsToMany(User::class, 'users_roles');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'roles_permissions');
    }
        /**
         * Scope a query to search role by name.
         */
    public function scopeWithName($query, $name)
    {
        return $name ? $query->where('name', 'LIKE', '%' . $name . '%') : null;
    }

    public function hasPermission($permissionName)
    {
        foreach ($this->permissions as $permission) {
            if ($permission->name == $permissionName) {
                return true;
            }
        }
        return false;
    }
}
