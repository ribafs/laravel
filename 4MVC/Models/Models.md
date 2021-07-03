# Models

Cada tabela tem um model correspondente, que é usado para interagir com a tabela. Um model permite gerenciar uma tabela. Cada model tem um controller correspondente. E cada controller tem algumas views ligadas a ele.

## Exemplo de paths:

- Tabela - produtos (plural)
- Model - app/Produto.php (singular, também o nome da classe: Produto)
- Controller - app/Http/Controllers/ProdutoController.php (singular com o sufixo Controller)
- Views - resources/views/produtos: index, create, edit e show

## Caso não queira seguir as convenções use no model para dizer ao Laravel:

protected $table = 'nome_tabela';

protected $primaryKey = 'cliente_id';

## Caso não queira usar os campos created_at e updated_at adiciona no model a linha:

public $timestamps = false;

## Os models, por default, ficam soltos na pasta app até a versão 7 do laravel, 

Podemos criar dentro de outras pastas, tendo o cuidado de alterar seu namespace no controller.

Nn versão 8 eles já vem por default na pasta app/Models, embora possamos os mover para app e funcionam, basta alterar o namespace.

Todo model Eloquent extend a classe

Illuminate\Database\Eloquent\Model

https://www.youtube.com/watch?v=eFuhNCFrR2E&index=12&list=PLVSNL1PHDWvTQnUQjhBEzY2ZSzJTR9zcZ

## Criar uma model com o artisan

php artisan make:model Carro

## Para criar juntamente com a migration:
php artisan make:model Carro -m

## Criar o model, a migration e o controller juntamente os actions default
php artisan make:model Cliente -mcr

Para o laravel uma tabela carros é representada por um model Carro.

## Criar o mesmo model com artisan em app/Models 

(já cria com o namespace correto em app/Models)

php artisan make:model Models/Produto

Para uma tabela chamada produtos um model Produto.

## Criar também a migration:
php artisan make:model Models/Produto -m

## No controller adicionar:
```php
use App\Models\Produto;

public function index(Produto $produto){

$produtos = Produto::all();
// Produto
$produto = Produto::find(1);
$total = Produto::count();
$maximo = Produto::max();
$soma = Produto::sum();
//Filtro
$users = User::where('gender', '=', 'Male')
->where('birth_date', '>', '1989-02-12')
->all();

$cat->name = 'Garfield';
$cat->save();

$cat = Cat::find(1);
$cat->delete();

	return view('produtos.index', compact('produtos'));
}
```
## Criar a view index em views/produtos/index.blade.php
```php
<h1>Listagem de Produtos</h1>

<table>
	<tr>
		<th>Nome</th>
		<th>Descrição</th>
	</tr>
	@foreach($produtos as $produto)
	<tr>
		<td>{{$produto->nome}}</td>
		<td>{{$produto->descricao}}</td>
	</r>
	@endforeach
</table>
```
## Criar uma rota para produtos

Route::resource('produtos', 'Produtos\ProdutoController');


## Model User
```php
<?php
namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}


// PrimaryKey associada a tabela
protected $primaryKey = 'flight_id';
public $incrementing = false;
protected $keyType = 'string';// Caso a PK não seja inteiro
public $timestamps = false;// Não deseja os campos created_at, updated_at e deleted_at
protected $dateFormat = 'd/m/Y'; // Formato de datas do model
```
Além disso, o Eloquent assume que a chave primária é um valor inteiro incremental, o que significa que, por padrão, a chave primária será convertida automaticamente para um int. Se você deseja usar uma chave primária não incremental ou não numérica, defina a propriedade públic $incrementing em seu modelo como false:

Após ter criado o model apropriadamente, podemos começar consultar a tabela.

```php
php artisan make:model Permission -m php artisan make:model Role -m

Relacionamentos

App/Role.php public function permissions() {

return $this->belongsToMany(Permission::class,'roles_permissions');

}

public function users() {

return $this->belongsToMany(User::class,'users_roles');

}

App/Permission.php public function roles() {

return $this->belongsToMany(Role::class,'roles_permissions');

}

public function users() {

return $this->belongsToMany(User::class,'users_permissions');

}

app/User.php namespace App;

use App\Permissions\HasPermissionsTrait;

class User extends Authenticatable { use HasPermissionsTrait; //Import The Trait }
```

Mais detalhes:
https://laravel.com/docs/8.x/eloquent#defining-models

