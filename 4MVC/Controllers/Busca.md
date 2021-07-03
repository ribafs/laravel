# Busca no Laravel 7

## No método index() do controller
```php
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 2;
        if (!empty($keyword)) {
            $clientes = Cliente::where('nome', 'LIKE', "%$keyword%")
                ->orWhere('email', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $clientes = Cliente::latest()->paginate($perPage);
        }
        return view('clientes.index', ["clientes" => $clientes]);
    }
```

## Na view index

Abaixo do botão adicionar novo registro
```php
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
```
Ao final da view
```php
...
                            </table>
                            <div class="pagination-wrapper"> {!! $clientes->appends(['search' => Request::get('search')])->render() !!} </div>
                        </div>
...
```

