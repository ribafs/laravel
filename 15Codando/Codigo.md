# Dicas de código no Laravel

## Passar alguns campos através do all()

$users = User::all(['id', 'name', 'email']); // Retornará todos os registros, mas com apenas estes campos

## Ordenação rápida

User::orderBy('created_at', 'desc')->get();

Melhor:

User::latest()->get(); // Por default, `latest()` deve ordenar pelo `created_at`.

# Listar pelos mais antigos

User::oldest()->get();

## Redirecionara para um método de outro controller

return redirect()->action('SomeController@method', ['param' => $value]);

## Agrupara pela primeira letra

$users = User::all()->groupBy(function($item) {
    return $item->name[0];
});

## Migrations

Para mudar a ordem de execução da migrate altere os nomes das migrations de acordo

Timestamp default

- $table->timestamp('created_at')->useCurrent();
- $table->timestamp('updated_at')->useCurrent();

## Diversas

```php
$userId = Auth::user()->id;
$userId = Auth::id();
$userId = auth()->id();

$users = User::all(['nome', 'email']);

$user = User::find(1);
$users = User::find([1,2,3]);

Copiar um registro
$task = Tasks::find(1);
$newTask = $task->replicate();
$newTask->save();

$collection = Person::all();
$programmers = $collection->where('type', 'programmer');

$collection = Person::all();
$grouped = $collection->groupBy('type');

Criar link simbólico para upload
php artisan storage:link
```
## Limitando requisições nas rotas

maximum of 10 requests for guests, 60 for authenticated users

```php
Route::middleware('throttle:10|60,1')->group(function () {
    //
});
```
## Mudar Token de API ao atualizar senha do user

Model:

```php
public function setPasswordAttribute($value)
{
    $this->attributes['password'] = $value;
    $this->attributes['api_token'] = Str::random(100);
}
```
```php
$newestContact = DB::table('contacts')
->orderBy('created_at', 'desc')
->first();

$contactFive = DB::table('contacts')->find(5);

$newestContactEmail = DB::table('contacts')
->orderBy('created_at', 'desc')
->value('email');

$highestCost = DB::table('orders')->max('amount');

$averageCost = DB::table('orders')
->where('status', 'completed')
->avg('amount');

Join
$users = DB::table('users')
->join('contacts', 'users.id', '=', 'contacts.user_id')
->select('users.*', 'contacts.name', 'contacts.status')
->get();

$first = DB::table('contacts')
->whereNull('first_name');

$contacts = DB::table('contacts')
->whereNull('last_name')
->union($first)
->get();

DB::table('contacts')
->where('points', '>', 100)
->update(['status' => 'vip']);

DB::table('users')
->where('last_login', '<', Carbon::now()->subYear())
->delete();

$allContacts = Contact::all();

$countVips = Contact::where('vip', true)->count();
$sumVotes = Contact::sum('votes');
$averageSkill = User::avg('skill_level');

Update
$contact = Contact::find(1);
$contact->email = 'natalie@parkfamily.com';
$contact->save();

$contact = Contact::find(1);
$contact->update(['longevity' => 'ancient']);

$contact = Contact::find(5);
$contact->delete();

Rotas para API com paginação
Route::get('clientes', function () {
  return Cliente::paginate(20);
});

$users = collect([...]);

$owner = $users->first(function ($user) {
  return $user->isOwner;
});

$firstUser = $users->first();
$lastUser = $users->last();

public function index()
    {
      $articles = Article::all();
      //$articles = Article::where('active', 1)->orderBy('title', 'desc')->take(10)->get();
      $users = User::all();
      $tags = Tag::all();
      return view('articles.index', ['articles' => $articles, 'users' => $users, 'tags'=>$tags]);
    }

$list = User::find(12);
echo $list->fullname;

$list->name = 'San Juan Vacation';
$list->description = 'Pre-vacation planning';
$list->save();

echo $list->id;

echo Todolist::all()->count();

$lists = Todolist::all();
foreach ($lists as $list) {
printf("%s\n", $list->name);
}

$lists->each(function($list) {
echo $list->name;
});

$lists = Todolist::orderBy('name')->get();

$lists = Todolist::where('complete', '=', 1)->get();

$lists = Todolist::where('complete', 1)->get();

$lists = Todolist::select(
DB::raw('year(created_at) as year'),
DB::raw('count(name) as count'))
->groupBy('year')
->where('year', '>', '2010')->get();

$list = Todolist::orderBy('created_at', 'asc')->first();

$list = Todolist::all()->random(1);

$lists = Todolist::orderBy('created_at', 'desc')->paginate(10);

$list = new Todolist;
$list->name = 'San Juan Vacation';
$list->description = 'Pre-vacation planning';
$list->save();

$list = Todolist::firstOrNew(array('name' => 'San Juan Vacation'));
$list->description('Too much to do before vacation!');
$list->save();

$list = Todolist::find(14);
$list->name = 'San Juan Holiday';
$list->save();

$list = Todolist::find(12);
$list->delete();

Todolist::destroy(12);

$lists = DB::table('todolists')->get();
foreach ($lists as $list) {
echo $list->name;
}

$lists = DB::table('todolists')->select('name')->get();

$lists = DB::select('SELECT * from todolists');

DB::insert('insert into todolists (name, description) values (?, ?)',array('San Juan Vacation', 'Things to do before vacation');
DB::update('update todolists set completed = 1 where id = ?', array(52));
DB::delete('delete from todolists where completed = 1');

$lists = DB::statement('drop table todolists');

 public function store(Request $request)
    {
        // Validate the request...

        $flight = new Flight;

        $flight->name = $request->name;

        $flight->save();
    }

$flight = App\Flight::find(1);

$flight->name = 'New Flight Name';

$flight->save();


$flight = App\Flight::find(1);

$flight->delete();


App\Flight::destroy(1);

App\Flight::destroy(1, 2, 3);

$deletedRows = App\Flight::where('active', 0)->delete();


 $builder->where('age', '>', 200);


public function testes()
{
	$prod = $this->produto;
	$prod->nome = 'Nome do produto';
	$prod->number = 123432;
	$prod->active = true;
	$prod->category = 'eletronicos';
	$prod->description = 'Descrição do produto';
	$insert = $prod->save();

	if ($insert)
		return 'Inserido com sucesso';
	else
		return 'Falha ao inserir';
}
```
## Para recuperar apenas alguns campos:

	$request->only(['nome', 'number']);

## Recupererar todos, exceto alguns:

	$request->except(['_token', 'categoria']);

## Recuperar apenas um campo
	$request->input('nome');

## Recuperar campo pelo seu nome

$request->name;

$produto = Produto::find(1);
$total = Produto::count();
$maximo = Produto::max();
$soma = Produto::sum();

//Filtro
$users = User::where('gender', '=', 'Male')->where('birth_date', '>', '1989-02-12')->all();

## Somar quantidade de todos os produtos de uma tabela

$total = Compra::all()->sum('quantidade');

## Média de compras dos clientes

$media = Compra::all()->avg();

## Maior valor de produtos vendidos

$max = Compra::all()->max('quantidade');

$max = Compra::orderBy('quantidade', 'desc')->get();

## Redirecionar para um método de outro controller

return redirect()->action('SomeController@method', ['param' => $value]);

## Reuest

```php
    public function store(Request $request)
    {
      // O request subentende que está chegando informações de formulários
      // E as informações que chegam serão armazenadas no banco de dados
      // Instanciar a classe do model
      $noticia = new Noticia;
      $noticia->title = $request->title;// Armazenar em title da notícia, o title que vem do form(request)
      $noticia->text = $request->text;
      $noticia->author = $request->author;
      $noticia->save();
      return redirect('/');
    }
```

## Dica para agilizar com requests em controllers

Ao invés de usar a injeção de dependência padrão do laravel em alguns métodos do controller

## Criar

```php
protected $request;

public function __construct(Request $request){
  $this->$request = $request;
}
```
Assim, agora nos métodos usar?

```php
$this->$request

// Dados que vem do formulário

$this->request->only('[(name)]');
$this->request->all();
$this->request->name;
```
## Saber se existe um campo

$this->request->has('name');// retorna true/false

## Capturar o valor de um campo

$this->request->input('name');

$this->request->input('name', 'default');

## Capturar todos os campos exceto este

$this->request->except('_token');
