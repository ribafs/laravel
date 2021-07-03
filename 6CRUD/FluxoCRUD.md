# Fluxo das informações em um CRUD no Laravel 7

As informações caminham no seguinte fluxo. Estarei descrevendo o fluxo de um CRUD criado pelo crud-generator, que pode ser um pouco diferente de outros CRUDs.
Algumas particularidades deste CRUD: busca, paginação e confirmação da exclusão.

Exemplo:
- routes tipo resource
- controller ClienteController
- model Cliente
- views clientes: index, create, edit e show

Rota

Route::resource('clientes', 'ClientesController');

Model

app/Cliente.php
```php
<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';
    protected $fillable = ['nome','email','ebdereco','fone'];    
}
```
Controller

app/Http/Controllers/ClienteController.php
```php
<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Cliente;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 5;
        if (!empty($keyword)) {
            clientes = Cliente::where('nome', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            clientes = Cliente::latest()->paginate($perPage);
        }
        return view('clientes.index', ['clientes' => clientes]);
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function store(Request $request)
    {        
        $requestData = $request->all();        
        Cliente::create($requestData);

        return redirect('clientes')->with('flash_message', 'Cliente added!');
    }

    public function show($id)
    {
        $cliente = Cliente::findOrFail($id);

        return view('clientes.show', compact('cliente'));
    }

    public function edit($id)
    {
        $cliente = Cliente::findOrFail($id);

        return view('clientes.edit', compact('cliente'));
    }

    public function update(Request $request, $id)
    {       
        $requestData = $request->all();
        
        $cliente = Cliente::findOrFail($id);
        $cliente->update($requestData);

        return redirect('clientes')->with('flash_message', 'Cliente updated!');
    }

    public function destroy($id)
    {
        Cliente::destroy($id);

        return redirect('clientes')->with('flash_message', 'Cliente deleted!');
    }
}
```
Views

resources/views/clientes

index.blade.php
```php
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('layouts.sidebar')

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Clientes</div>
                    <div class="card-body">
                        <a href="{{ url('/clientes/create') }}" class="btn btn-success btn-sm" title="Add New Cliente">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add New
                        </a>

                        <form method="GET" action="{{ url('/clientes') }}" accept-charset="UTF-8" class="form-inline my-2 my-lg-0 float-right" role="search">
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" placeholder="Search..." value="{{ request('search') }}">
                                <span class="input-group-append">
                                    <button class="btn btn-secondary" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </form>

                        <br/>
                        <br/>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th><th>Nome</th><th>Email</th><th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($clientes as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->nome }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>
                                            <a href="{{ url('/clientes/' . $item->id) }}" title="View Cliente"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                            <a href="{{ url('/clientes/' . $item->id . '/edit') }}" title="Edit Cliente"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                                            <form method="POST" action="{{ url('/clientes' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                                {{ method_field('DELETE') }}
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete Cliente" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-wrapper"> {!! $clientes->appends(['search' => Request::get('search')])->links('layouts.bootstrap-4')->render() !!} </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
```
create.blade.php
```php
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Create New Cliente</div>
                    <div class="card-body">
                        <a href="{{ url('/clientes') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        <form method="POST" action="{{ url('/clientes') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            @include ('clientes.form', ['formMode' => 'create'])

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
```
edit.blade.php
```php
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Edit Cliente #{{ $cliente->id }}</div>
                    <div class="card-body">
                        <a href="{{ url('/clientes') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <br />
                        <br />

                        @if ($errors->any())
                            <ul class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif

                        <form method="POST" action="{{ url('/clientes/' . $cliente->id) }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                            {{ method_field('PATCH') }}
                            {{ csrf_field() }}

                            @include ('clientes.form', ['formMode' => 'edit'])

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
```
show.blade.php
```php
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Cliente {{ $cliente->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/clientes') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/clientes/' . $cliente->id . '/edit') }}" title="Edit Cliente"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                        <form method="POST" action="{{ url('clientes' . '/' . $cliente->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete Cliente" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $cliente->id }}</td>
                                    </tr>
                                    <tr><th> Nome </th><td> {{ $cliente->nome }} </td></tr><tr><th> Email </th><td> {{ $cliente->email }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
```
form.blade.php (usado pelas views edit e create)
```php
<div class="form-group {{ $errors->has('nome') ? 'has-error' : ''}}">
    <label for="nome" class="control-label">{{ 'Nome' }}</label>
    <input class="form-control" name="nome" type="text" id="nome" value="{{ isset($cliente->nome) ? $cliente->nome : ''}}" >
    {!! $errors->first('nome', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
    <label for="email" class="control-label">{{ 'Email' }}</label>
    <input class="form-control" name="email" type="text" id="email" value="{{ isset($cliente->email) ? $cliente->email : ''}}" >
    {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
```
Agora vejamos o caminho das informações nas várias ações do CRUD
```php
php artisan serve
localhost:8000/clientes
```
index
```php
- Route::resource('clientes', 'ClientesController');
```
clientes.index

Ao chamar esta rota o ClienteController é chamado em seu action index() e este action chama a view clientes.index

A view index lista todos os registros da referida tabela, de acordo com o código do action indes().
Além de listar os registros esta view tem 4 botões: new, edit, view e delete, além do botão de busca.

create/store

Ao clicar no botão new o action create() é chamado. Então este action chama a view clientes.create.
Esta view mostra um form vazio para se cadasrar um registro. Quando clicamos no submit da view create o action store() é chamado. Este action se encarrega de armazenar as informações no banco e voltar para a view clientes.index.

edit/update

Ao clicar no botão edit de alguns dos registros, o action edit($id) é chamado com o respectivo id (/clientes/id/edit). O action traz do banco as informações sobre o id e devolve para a view edit, que mostra as informações num formulário. Após efetuaar as alterações pretendidas e clicar no submit os resultados serão enviados para o action update, que os processa e envia para o banco de dados. Então devolve para a view clientes.index.

view/show

Na index ao clicar no botão View em algum dos registros o action show(id) é chamado (clientes/id). Então as informações do registro são devolvidas pelo action para a view show em forma de tabela HTML. Aí teremos 3 botões: Back, Edit e Delete.

delete/destroy

Estando na index e clicando no botão Delete, recebemos um diálogo do JavaScript para confirmar ou não o delete. Ao confirmar será chamado o action destroy(id) que se encarregará de remover o registro especificado pelo id (clientes/id). O que identifica o action destroy() é o método DELETE. Então direcionará para a clientes.index.


