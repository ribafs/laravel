<?php

namespace CodeArtisan\LaravelAcl;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasPermission
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions() : BelongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }

    /**
     * @param string|int $permission
     *
     * @return bool
     */
    public function hasPermission($permission) : bool
    {
        $permission = $this->getPermissionModel($permission);

        if (!$permission) {
            return false;
        }

        return $this->hasDirectPermission($permission) || $this->hasRolePermission($permission);
    }

    /**
     * @param string|int|\CodeArtisan\LaravelAcl\Permission $permission
     *
     * @return bool
     */
    public function hasDirectPermission($permission) : bool
    {
        $permission = $this->getPermissionModel($permission);

        if (!$permission) {
            return false;
        }

        return (bool) $this->permissions()->find($permission->id);
    }

    /**
     * @param string|int|\CodeArtisan\LaravelAcl\Permission $permission
     *
     * @return bool
     */
    public function hasRolePermission($permission) : bool
    {
        $permission = $this->getPermissionModel($permission);

        if (!$permission) {
            return false;
        }

        foreach ($this->roles as $role) {
            $rolePermissions = $role->permissions->pluck('key')->toArray();
            if (in_array($permission->key, $rolePermissions)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string|int $permission
     *
     * @return void
     */
    public function grantPermission($permission)
    {
        $permission = $this->getPermissionModel($permission);

        if ($permission) {
            $this->permissions()->attach($permission->id);
        }
    }

    /**
     * @param string|int $permission
     *
     * @return void
     */
    public function revokePermission($permission)
    {
        $permission = $this->getPermissionModel($permission);

        if ($permission) {
            $this->permissions()->detach($permission->id);
        }
    }

    /**
     * @param string|int $permission
     *
     * @return \CodeArtisan\LaravelAcl\Permission
     */
    public function getPermissionModel($permission)
    {
        if ($permission instanceof Permission) {
            return $permission;
        }

        return Permission::findPermission($permission);
    }
}
