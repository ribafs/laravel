# Paginação em duas etapas

## No index() do controller
```php
    public function index(Request $request)
    {
            $clients = Client::latest()->paginate(2);
        return view('clients.index', ["clients" => $clients]);
    }
```
## Na view index

Ao final
```php
...
                            </table>
                            <div class="pagination-wrapper">{!! $clients->appends(Request::all())->links() !!} </div>
```
Ou apenas
```php
...
<div class="pagination-wrapper">{{ $clients->links() }}</div>
...
```
## Com bootstrap
```php
{{ $clients->links('vendor.pagination.bootstrap-4') }}
```
## Com busca
```php
        <div class="pagination-wrapper"> {!! $clients->appends(['search' => Request::get('search')])->links('vendor.pagination.bootstrap-4')->render() !!} </div>
```
