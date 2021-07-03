# Roles e Permissions from Scratch
```php
- Instalar laravel
  laravel new acl
  cd acl
- Configurar banco
- Criar scaffold da auenticação
composer require laravel/ui --dev
php artisan ui bootstrap --auth
npm install & npm run dev
```
Teste
```php
php artisan serve

localhost:8000
```
Gerar models com migrations
```php
php artisan make:model Role -m
php artisan make:model Permission -m

roles

        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
        });

    public function down()
    {
        Schema::dropIfExists('roles');
    }

permissions

        Schema::create('permissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('permissions');
    }
```
Tabelas pivo

Definir alguns relacionamentos que você pode implementar para roles e permissions

- User pode tere permissions
- User pode ter roles
- Uma role pode ter permissions

Dos três relacionamentos acima, precisaremos adicionar três tabelas dinâmicas para criar um relacionamento Muitos para Muitos entre os modelos User, Role e Permission.

users_permissions
```php
php artisan make:migration create_users_permissions_table

<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_permissions', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('permission_id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');

            $table->primary(['user_id','permission_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_permissions');
    }
}
```
users_roles
```php
php artisan make:migration create_users_roles_table

<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_roles', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('role_id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');

            $table->primary(['user_id','role_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_roles');
    }
}
```
roles_permissions
```php
php artisan make:migration create_roles_permissions_table

<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles_permissions', function (Blueprint $table) {
            $table->unsignedInteger('role_id');
            $table->unsignedInteger('permission_id');

            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');

            $table->primary(['role_id','permission_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles_permissions');
    }
}
```
php artisan migrate

Relacionamento entre roles e permissions
```php
app\Role.php

<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function permissions()
    {
        return $this->belongsToMany(Permission::class,'roles_permissions');
    }
}
```
app\Permission.php
```php
<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public function roles()
    {
        return $this->belongsToMany(Role::class,'roles_permissions');
    }
}
```
Criar o trait HasRolesAndPermissions para o model User
```php
Um user pode ter muitas permissions
Um user pode ter muitas roles
Uma role pode ter muitos users e 
Permission pode ter muitos users
```
Precisamos criar um relacionamento many to many no model User

Criar a nova pasta

app/Traits

Criar

app/Traits/HasRolesAndPermissions.php
```php
<?php
namespace App\Traits;

use App\Role;
use App\Permission;
trait HasRolesAndPermissions
{
    /**
     * @return mixed
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class,'users_roles');
    }

    /**
     * @return mixed
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class,'users_permissions');
    }
}

Editar o app/User.php e deixar assim:

<?php
namespace App;

use App\Traits\HasRolesAndPermissions;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, HasRolesAndPermissions; // Our new trait

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
```
Para checar se o user logado tem alguma role, adicionar a função hasRole no trait HasRolesAndPermissions:
```php
/**
 * @param mixed ...$roles
 * @return bool
 */
public function hasRole(... $roles ) {
    foreach ($roles as $role) {
        if ($this->roles->contains('slug', $role)) {
            return true;
        }
    }
    return false;
}
```
Nesta função, estamos passando o array $functions e executando um para cada loop em cada role para verificar se as funções do usuário atual contêm alguma role especificada.

User hasPermission

Para obter a permission do usuário atual, adicionaremos os dois métodos abaixo em nossa trait HasRolesAndPermissions:
```php
/**
 * @param $permission
 * @return bool
 */
protected function hasPermission($permission)
{
    return (bool) $this->permissions->where('slug', $permission->slug)->count();
}

/**
 * @param $permission
 * @return bool
 */
protected function hasPermissionTo($permission)
{
    return $this->hasPermission($permission);
}
```
O método acima irá checar se as permissões do usuário contém uma permission listada. Se sim iste irá retornar true, caso contrário retornará false.

User hasPermissionThroughRole

Temos muitos relacionamentos entre roles e permissões. Isso nos permite verificar se um usuário tem permissão através de sua role. Para implementar isso, teremos uma nova função em nosso trait HasRolesAndPermissions. Adicione o método abaixo no seu arquivo de trait
```php
/**
 * @param $permission
 * @return bool
 */
public function hasPermissionThroughRole($permission)
{
    foreach ($permission->roles as $role){
        if($this->roles->contains($role)) {
            return true;
        }
    }
    return false;
}
```
Esta função verifica se a função da permission está anexada ao user ou não. Agora, o método hasPermissionTo() verificará entre essas duas condições.

Atualizar o método hasPermissionTo como abaixo:
```php
/**
 * @param $permission
 * @return bool
 */
protected function hasPermissionTo($permission)
{
   return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission);
}
```
Agora temos um método que verifica se um user tem as permissioons diretamente ou através de uma role. Usaremos esse método para adicionar uma diretiva de blade personalizada.

Dando permissões

Agora vamos anexar algumas permissões ao usuário atual. Iremos adicionar um novo método para realizar isso. Adicione o método abaixo para o trait HasRolesAndPermissions:
```php
/**
 * @param array $permissions
 * @return mixed
 */
protected function getAllPermissions(array $permissions)
{
    return Permission::whereIn('slug',$permissions)->get();
}

/**
 * @param mixed ...$permissions
 * @return $this
 */
public function givePermissionsTo(... $permissions)
{
    $permissions = $this->getAllPermissions($permissions);
    if($permissions === null) {
        return $this;
    }
    $this->permissions()->saveMany($permissions);
    return $this;
}
```
O primeiro método é para receber todas as permissões baseadas em um array passado. Na segunda função, nós passamos permissões como um array e recebemos todas as permissões do banco de dados baseados no array.

Então nós usamos o método permissions() para chamar o método saveMany() para salvar as permissões para o user atual.

Excluindo permissões

Para excluir permissões de um usuário, nós passamos permissões para nosso método deletePermissions() e removemos todas as permissões anexadas usando o método detach()
```php
/**
 * @param mixed ...$permissions
 * @return $this
 */
public function deletePermissions(... $permissions )
{
    $permissions = $this->getAllPermissions($permissions);
    $this->permissions()->detach($permissions);
    return $this;
}

/**
 * @param mixed ...$permissions
 * @return HasRolesAndPermissions
 */
public function refreshPermissions(... $permissions )
{
    $this->permissions()->detach();
    return $this->givePermissionsTo($permissions);
}
```
O segundo método remove todas as permissões de um usuário e então reatribui as permissões providas para o usuário.

Adicionando Seeders

Já implementando roles e permissions, ainda não testamos nada. Para um teste rápido vamos adicionar um seed, que deve adicionar algum dado de teste para as tabelas.
```php
php artisan make:seed PermissionSeeder
php artisan make:seed RoleSeeder
php artisan make:seed UserSeeder

<?php
use App\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $manager = new Role();
        $manager->name = 'Project Manager';
        $manager->slug = 'project-manager';
        $manager->save();

        $developer = new Role();
        $developer->name = 'Web Developer';
        $developer->slug = 'web-developer';
        $developer->save();
    }
}
```
permission_seeder
```php
use App\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $manageUser = new Permission();
        $manageUser->name = 'Manage users';
        $manageUser->slug = 'manage-users';
        $manageUser->save();

        $createTasks = new Permission();
        $createTasks->name = 'Create Tasks';
        $createTasks->slug = 'create-tasks';
        $createTasks->save();
    }
}
```
user_seeder
```php
use App\Role;
use App\User;
use App\Permission;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $developer = Role::where('slug','web-developer')->first();
        $manager = Role::where('slug', 'project-manager')->first();
        $createTasks = Permission::where('slug','create-tasks')->first();
        $manageUsers = Permission::where('slug','manage-users')->first();

        $user1 = new User();
        $user1->name = 'Jhon Deo';
        $user1->email = 'jhon@deo.com';
        $user1->password = bcrypt('secret');
        $user1->save();
        $user1->roles()->attach($developer);
        $user1->permissions()->attach($createTasks);


        $user2 = new User();
        $user2->name = 'Mike Thomas';
        $user2->email = 'mike@thomas.com';
        $user2->password = bcrypt('secret');
        $user2->save();
        $user2->roles()->attach($manager);
        $user2->permissions()->attach($manageUsers);
    }
}
```
Atualizar run() no DatabaseSeeder
```php
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(UserSeeder::class);
    }

php artisan db:seed
```
Testar as permissions e roles para um user como abaixo
```php
$user = App\User::find(1);
dd($user->hasRole('web-developer'); // will return true
dd($user->hasRole('project-manager');// will return false
dd($user->givePermissionsTo('manage-users'));
dd($user->hasPermission('manage-users');// will return true
```
Adicionar diretivas Blade customizadas para roles e permissions

Para criar uma diretiva customizada do Blade, devemos criar um novo ServiceProvider
```php
php artisan make:provider RolesServiceProvider
```
Editar o RolesServiceProvider.php e deixar assim:
```php
app/Providers/RolesServiceProvider.php

<?php
namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class RolesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('role', function ($role){
            return "<?php if(auth()->check() && auth()->user()->hasRole({$role})) :";
        });

        Blade::directive('endrole', function ($role){
            return "<?php endif; ?>";
        });
    }
}
```
No método boot() do service provider acima, estamos declarando uma diretiva personalizada usando a Blade::facede. Em nossa primeira diretiva, estamos verificando se o usuário está autenticado e se o usuário tem a role especificada. Na segunda diretiva do Blade, estamos fechando a instrução if.

Em nosso arquivo de view podemos usar algo como:
```php
@role('project-manager')
Project Manager Panel
@endrole @role(‘web-developer’)
Web Developer Panel
@endrole
```
Nós temos usado roles em nossa diretiva customizada. Para permissions podemos usar a diretiva
@can para checar se um usuário tem permissão e ao invés de usar 
$user->hasPermissionTo() usremos $user->can().

Criaremos um novo service provider
```php
app/Providers/PermissionsServiceProvider.php

<?php
namespace App\Providers;
use App\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class PermissionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
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
    }
}
```
Aqui, o que estamos fazendo é mapear todas as permissões, definir essa slug de permissão (no nosso caso) e finalmente verificar se o usuário tem permissão. Agora você pode verificar a permissão do usuário, como abaixo:
```php
dd($user->can('manage-users')); // will return true
```
Adicionando Middlewares para Roles e Permissões

Podemos criar roles para áreas específicas do aplicativo. Por exemplo, você pode fornecer acesso para gerenciar a seção do usuário apenas para gerentes de projeto. Para isso, usaremos o Laravel Middleware. Usando o middleware, podemos adicionar controle extra às solicitações recebidas no seu aplicativo.

Para criar um middleware para funções, execute o comando abaixo.

php artisan make:middleware RoleMiddleware

Abra o app/Http/Middleware/RoleMiddleware.php e deixe assim:
```php
<?php
namespace App\Http\Middleware;

use Closure;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * @param $request
     * @param Closure $next
     * @param $role
     * @param null $permission
     * @return mixed
     */
    public function handle($request, Closure $next, $role, $permission = null)
    {
        if(!auth()->user()->hasRole($role)) {
            abort(404);
        }
        if($permission !== null && !auth()->user()->can($permission)) {
            abort(404);
        }
        return $next($request);
    }
}
```
Neste middleware, estamos verificando se o usuário atual não possui a role/permissão especificada e, em seguida, retorne a página de erro 404. Existem muitas possibilidades de usar roles e permissões no middleware para controlar as solicitações recebidas, tudo depende dos requisitos do seu aplicativo.
Antes de usar este middleware, você deve adicioná-lo ao seu arquivo App\Http\Kernel.php.
```php
protected $routeMiddleware = [
...
'role'  =>  \App\Http\Middleware\RoleMiddleware::class, // our role middleware
...
```
Agora podemos usar o middleware:
```php
Route::group(['middleware' => 'role:project-manager'], function() {
   Route::get('/dashboard', function() {
      return 'Welcome Project Manager';
   });
});
```
Criar novo usuário
Conceder role e permissão
```php
php artisan serve

localhost:8000/login
```

https://www.larashout.com/laravel-roles-and-permissions
https://github.com/LaraShout/laravel-roles-permissions
