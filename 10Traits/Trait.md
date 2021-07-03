# HasPermissionsTrait.php
```php
<?php
namespace App\Permissions;

use App\Permission;
use App\Role;

trait HasPermissionsTrait {

   public function roles() {
      return $this->belongsToMany(Role::class,'users_roles');

   }


   public function permissions() {
      return $this->belongsToMany(Permission::class,'users_permissions');

   }
}
```
Now, we’ll create a new function inside our HasPermissionsTrait.php and name it as hasRole as following
```php
public function hasRole( ... $roles ) {
   foreach ($roles as $role) {
      if ($this->roles->contains('slug', $role)) {
         return true;
      }
   }
   return false;
}
```
Here, we’re iterating through the roles and checking by the slug field, if that specific role exists. You can check or debug this by using:
```php
$user = $request->user(); //getting the current logged in user
dd($user->hasRole('admin','editor')); // and so on
```
Now we need to build the ability to give a user some permissions. But wait, here we have a couple of conditions to tackle with:
– User may have individual Permission for some actions.
Back inside of HasPermissionsTrait.php, we will add some new methods for user permissions:
```php
protected function hasPermissionTo($permission) {
   return $this->hasPermission($permission);
}

protected function hasPermission($permission) {
   return (bool) $this->permissions->where('slug', $permission->slug)->count();
}
```
We’ll be utilizing the Laravel’s “can” directive to check if the User have Permission. and instead of using $user->hasPermissionTo(), we’ll use $user->can() To do so, we need to create a new PermissionsServiceProvider for authorization
```php
$ php artisan make:provider PermissionsServiceProvider
Register your service provider and head over to the boot method to provide us a Gateway to use can() method.
//PermissionsServiceProvider.php 
public function boot()
 {
     Permission::get()->map(function($permission){
Gate::define($permission->slug, function($user) use ($permission){
   return $user->hasPermissionTo($permission);
});
     });
 }
```
Here, what we’re doing is, mapping through all permissions, defining that permission slug (in our case) and finally checking if the user has permission. You can learn more about Laravel’s Gate facade at Laravel’s documentation. You can test it out as:
```php
dd($user->can('permission-slug'));
```
– User may have Permission through a Role
To achieve this condition, in our HasPermissionsTrait.
```php
//HasPermissionsTrait.php
public function hasPermissionThroughRole($permission) {
   foreach ($permission->roles as $role){
      if($this->roles->contains($role)) {
         return true;
      }
   }
   return false;
}
```
Here, we’re iterating through each permission associated with a role, remember we’ve a many to many relationship setup between roles and permissions table.
Now the hasPermissionTo() method will check between these two conditions.
```php
//HasPermissionsTrait.php
public function hasPermissionTo($permission) {
   return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission);
}
```
Giving Permissions
Now let’s say, we want to give a set of permissions to a logged in user, here’s how we can achieve this
```php
//HasPermissionsTrait.php
public function givePermissionsTo(... $permissions) {
   $permissions = $this->getAllPermissions($permissions);
   dd($permissions);
   if($permissions === null) {
      return $this;
   }
   $this->permissions()->saveMany($permissions);
   return $this;
}
```
Deleting Permissions
For deleting or removing permissions from the user scope, we can use the detach method.
```php
//HasPermissionsTrait.php
public function deletePermissions( ... $permissions ) {
   $permissions = $this->getAllPermissions($permissions);
   $this->permissions()->detach($permissions);
   return $this;
}
```
This is pretty straight forward, same things will be applied for roles as well. So give it a try and leave us a comment on how you did it.

