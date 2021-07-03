<?php

namespace CodeArtisan\LaravelAcl;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasRole
{
    use HasPermission;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles() : BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * @param string|int $role
     *
     * @return bool
     */
    public function hasRole($role) : bool
    {
        $role = $this->roles()->whereName($role)->first();

        return ($role) ? true : false;
    }

    /**
     * @param array $roles
     *
     * @return bool
     */
    public function hasAnyRole(array $roles) : bool
    {
        return $this->roles()->whereIn('name', $roles)->count() > 0;
    }

    /**
     * @param array $roles
     *
     * @return bool
     */
    public function hasAllRoles(array $roles) : bool
    {
        $assignedRoles = $this->roles->pluck('name')->toArray();

        foreach ($roles as $role) {
            if (!in_array($role, $assignedRoles)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param string|int $role
     *
     * @return void
     */
    public function assignRole($role) : void
    {
        if (null !== ($role = Role::findRole($role))) {
            $this->roles()->syncWithoutDetaching($role->id);
        }
    }

    /**
     * @param string|int $role
     *
     * @return void
     */
    public function revokeRole($role) : void
    {
        if (null !== ($role = Role::findRole($role))) {
            $this->roles()->detach($role);
        }
    }

    /**
     * @param array $roles
     *
     * @return void
     */
    public function syncRoles(array $roles)
    {
        foreach ($roles as &$role) {
            $role = Role::findRole($role)->id;
        }

        $roles = array_filter($roles);
        $this->roles()->sync($roles);
    }
}
