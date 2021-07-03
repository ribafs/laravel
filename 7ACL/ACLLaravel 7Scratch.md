# Roles/Funções e Permissões no Laravel 7 sem pacotes

https://github.com/techmahedy/user-roles-and-permission-access

laravel new roles-scratch

cd roles-scratch
```php
composer require laravel/ui --dev
php artisan ui vue --auth
npm install
npm run watch

php artisan make:model Permission -m
php artisan make:model Role -m

public function up()
    {
       Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email',191)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
    });
}

    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name'); // edit posts
            $table->string('slug'); //edit-posts
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('permissions');
    }

    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name'); // edit posts
            $table->string('slug'); //edit-posts
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('roles');
    }
```
Tabela pivo
```php
php artisan make:migration create_users_permissions_table --create=users_permissions

    public function up()
    {
        Schema::create('users_permissions', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('permission_id');

            //FOREIGN KEY CONSTRAINTS
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
 
            //SETTING THE PRIMARY KEYS
            $table->primary(['user_id','permission_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('users_permissions');
    }

php artisan make:migration create_users_roles_table --create=users_roles

    public function up()
    {
        Schema::create('users_roles', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('role_id');

         //FOREIGN KEY CONSTRAINTS
           $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
           $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');

         //SETTING THE PRIMARY KEYS
           $table->primary(['user_id','role_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('users_roles');
    }
```

Under a particular Role, User may have specific Permission
For example, a user may have the permission for post a topic, and an admin may have the permission to edit or delete a topic. In this case, let’s setup a new table for roles_permissions to handle this complexity.
```php
php artisan make:migration create_roles_permissions_table --create=roles_permissions

    public function up()
    {
        Schema::create('roles_permissions', function (Blueprint $table) {
             $table->unsignedInteger('role_id');
             $table->unsignedInteger('permission_id');

             //FOREIGN KEY CONSTRAINTS
             $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
             $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');

             //SETTING THE PRIMARY KEYS
             $table->primary(['role_id','permission_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('roles_permissions');
    }

php artisan migrate
```
Relacionamentos
```php
App/Role.php
public function permissions() {

   return $this->belongsToMany(Permission::class,'roles_permissions');
       
}

public function users() {

   return $this->belongsToMany(User::class,'users_roles');
       
}

App/Permission.php
public function roles() {

   return $this->belongsToMany(Role::class,'roles_permissions');
       
}

public function users() {

   return $this->belongsToMany(User::class,'users_permissions');
       
}

app/User.php
namespace App;

use App\Permissions\HasPermissionsTrait;

class User extends Authenticatable
{
    use HasPermissionsTrait; //Import The Trait
}
```
Editar app/Permissions/HasPermissionsTrait.php e colar:
```php
<?php

namespace App\Permissions;

use App\Permission;
use App\Role;

trait HasPermissionsTrait {

   public function givePermissionsTo(... $permissions) {

    $permissions = $this->getAllPermissions($permissions);
    dd($permissions);
    if($permissions === null) {
      return $this;
    }
    $this->permissions()->saveMany($permissions);
    return $this;
  }

  public function withdrawPermissionsTo( ... $permissions ) {

    $permissions = $this->getAllPermissions($permissions);
    $this->permissions()->detach($permissions);
    return $this;

  }

  public function refreshPermissions( ... $permissions ) {

    $this->permissions()->detach();
    return $this->givePermissionsTo($permissions);
  }

  public function hasPermissionTo($permission) {

    return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission);
  }

  public function hasPermissionThroughRole($permission) {

    foreach ($permission->roles as $role){
      if($this->roles->contains($role)) {
        return true;
      }
    }
    return false;
  }

  public function hasRole( ... $roles ) {

    foreach ($roles as $role) {
      if ($this->roles->contains('slug', $role)) {
        return true;
      }
    }
    return false;
  }

  public function roles() {

    return $this->belongsToMany(Role::class,'users_roles');

  }
  public function permissions() {

    return $this->belongsToMany(Permission::class,'users_permissions');

  }
  protected function hasPermission($permission) {

    return (bool) $this->permissions->where('slug', $permission->slug)->count();
  }

  protected function getAllPermissions(array $permissions) {

    return Permission::whereIn('slug',$permissions)->get();
    
  }

}
```

Checar e debugar
```php
$user = $request->user(); //getting the current logged in user
dd($user->hasRole('admin','editor')); // and so on
```

Criar Provider
```php
php artisan make:provider PermissionsServiceProvider

<?php
namespace App\Providers;

use App\Permission;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class PermissionsServiceProvider extends ServiceProvider
{
   
    public function register()
    {
        //
    }

    public function boot()
    {
        try {
            Permission::get()->map(function ($permission) {
                Gate::define($permission->slug, function ($user) use ($permission) {
                    return $user->hasPermissionTo($permission);
                });
            });
        } catch (\Exception $e) {
            report($e);
            return false;
        }

        //Blade directives
        Blade::directive('role', function ($role) {
             return "if(auth()->check() && auth()->user()->hasRole({$role})) :"; //return this if statement inside php tag
        });

        Blade::directive('endrole', function ($role) {
             return "endif;"; //return this endif statement inside php tag
        });

    }
}
```

Registrar
```php
config\app.php
 'providers' => [

        App\Providers\PermissionsServiceProvider::class,
    
 ],
```

https://laravel.com/docs/7.x/authorization#gates


Testar
```php
dd($user->can('permission-slug'));
```

Rota
```php
Route::get('/roles', 'PermissionController@Permission');
```

Controllers
```php
App\Http\Controllers\PermissionController.php

<?php
namespace App\Http\Controllers;

use App\Permission;
use App\Role;
use App\User;
use Illuminate\Http\Request;

class PermissionController extends Controller
{   

    public function Permission()
    {   
        $dev_permission = Permission::where('slug','create-tasks')->first();
                $manager_permission = Permission::where('slug', 'edit-users')->first();

                //RoleTableSeeder.php
                $dev_role = new Role();
                $dev_role->slug = 'developer';
                $dev_role->name = 'Front-end Developer';
                $dev_role->save();
                $dev_role->permissions()->attach($dev_permission);

                $manager_role = new Role();
                $manager_role->slug = 'manager';
                $manager_role->name = 'Assistant Manager';
                $manager_role->save();
                $manager_role->permissions()->attach($manager_permission);

                $dev_role = Role::where('slug','developer')->first();
                $manager_role = Role::where('slug', 'manager')->first();

                $createTasks = new Permission();
                $createTasks->slug = 'create-tasks';
                $createTasks->name = 'Create Tasks';
                $createTasks->save();
                $createTasks->roles()->attach($dev_role);

                $editUsers = new Permission();
                $editUsers->slug = 'edit-users';
                $editUsers->name = 'Edit Users';
                $editUsers->save();
                $editUsers->roles()->attach($manager_role);

                $dev_role = Role::where('slug','developer')->first();
                $manager_role = Role::where('slug', 'manager')->first();
                $dev_perm = Permission::where('slug','create-tasks')->first();
                $manager_perm = Permission::where('slug','edit-users')->first();

                $developer = new User();
                $developer->name = 'Mahedi Hasan';
                $developer->email = 'mahedi@gmail.com';
                $developer->password = bcrypt('secrettt');
                $developer->save();
                $developer->roles()->attach($dev_role);
                $developer->permissions()->attach($dev_perm);

                $manager = new User();
                $manager->name = 'Hafizul Islam';
                $manager->email = 'hafiz@gmail.com';
                $manager->password = bcrypt('secrettt');
                $manager->save();
                $manager->roles()->attach($manager_role);
                $manager->permissions()->attach($manager_perm);

                
                return redirect()->back();
    }
}
```

Testar
```php
$user = $request->user();
dd($user->hasRole('developer')); //will return true, if user has role
dd($user->givePermissionsTo('create-tasks'));// will return permission, if not null
dd($user->can('create-tasks')); // will return true, if user has permission
```

Numa view
```php
@role('developer')

 Hello developer

@endrole
```

Para proteger as rotas podemos usar um middleware
```php
php artisan make:middleware RoleMiddleware
```
Adicionar o middleware ao Kernel e configurar
```php
App\Http\Middleware\RoleMiddleware.php
namespace App\Http\Middleware;

use Closure;

class RoleMiddleware
{

    public function handle($request, Closure $next, $role, $permission = null)
    {
        if(!$request->user()->hasRole($role)) {
             abort(404);

        }

        if($permission !== null && !$request->user()->can($permission)) {
              abort(404);
        }

        return $next($request);

    }
}


App\Http\Kernel.php
protected $routeMiddleware = [
    .
    .
    'role' => \App\Http\Middleware\RoleMiddleware::class,
];
```

Agora nas rotas podemos fazer assim:
```php
Route::group(['middleware' => 'role:developer'], function() {

   Route::get('/admin', function() {

      return 'Welcome Admin';
      
   });

});
```

Agora você pode usar seu controller como abaixo para dar permissão e acesso ao usuário.
```php
public function __construct()
{
   $this->middleware('auth'); 
}


public function store(Request $request)
{
    if ($request->user()->can('create-tasks')) {
        //Code goes here
    }
}

public function destroy(Request $request, $id)
{   
    if ($request->user()->can('delete-tasks')) {
      //Code goes here
    }

}
```

Agora, apenas os usuários podem acessar esta rota cuja role/função é developer.
```php
php artisan key:gen
```
Adicionar um usuário
```php
php artisan tinker

use App\User;
User::create(['name'=>'Ribamar FS', 'email'=>'ribafs@gmail.com', 'password' => bcrypt(123456)]);

php artisan serve

localhost:8000

ribafs@gmail.com - 123456
```
https://www.codechief.org/article/user-roles-and-permissions-tutorial-in-laravel-without-packages#gsc.tab=0


