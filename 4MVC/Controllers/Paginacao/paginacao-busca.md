# Paginação e Busca como no aplicativo crud-unha

## Adicionar a busca e a paginação ao método index do Controller
```php
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 2;

        if (!empty($keyword)) {
            $clientes = Cliente::where('nome', 'LIKE', "%$keyword%")
				->orWhere('fone', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $clientes = Cliente::paginate($perPage);
        }

        return view('clientes.index', compact('clientes'));
    }
```

## Na view index.blade.php respectiva:
```php
<form action="/clientes" method="GET">
    <div class="input-group">
	    <input type="text" class="form-control" name="search" placeholder="Busca...">
	</div>
	    <input type="submit" name="name" class="btn btn-warning btn-xs" value="Busca">
</form>

ou
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

Ao final, logo abaixo

 </table>
	<div class="pagination-wrapper"> {!! $clientes->appends(['search' => Request::get('search')])->render() !!} </div>

ou
                            <div class="pagination-wrapper"> {!! $clientes->appends(['search' => Request::get('search')])->render() !!} </div>

Este exemplo foi adaptado de um exemplo criado pelo crug_generator.

https://www.youtube.com/watch?v=ZCBin49nIno&list=PLVSNL1PHDWvQBtcH_4VR82Dg-aFiVOZBY&index=50

## Métodos extras de paginação
```php
Method 	              Description
$paginator->count() 	Get the number of items for the current page.
$paginator->currentPage() 	Get the current page number.
$paginator->firstItem() 	Get the result number of the first item in the results.
$paginator->getOptions() 	Get the paginator options.
$paginator->getUrlRange($start, $end) 	Create a range of pagination URLs.
$paginator->hasPages() 	Determine if there are enough items to split into multiple pages.
$paginator->hasMorePages() 	Determine if there is more items in the data store.
$paginator->items() 	Get the items for the current page.
$paginator->lastItem() 	Get the result number of the last item in the results.
$paginator->lastPage() 	Get the page number of the last available page. (Not available when using simplePaginate).
$paginator->nextPageUrl() 	Get the URL for the next page.
$paginator->onFirstPage() 	Determine if the paginator is on the first page.
$paginator->perPage() 	The number of items to be shown per page.
$paginator->previousPageUrl() 	Get the URL for the previous page.
$paginator->total() 	Determine the total number of matching items in the data store. (Not available when using simplePaginate).
$paginator->url($page) 	Get the URL for a given page number.
$paginator->getPageName() 	Get the query string variable used to store the page.
$paginator->setPageName($name) 	Set the query string variable used to store the page.
```
https://laravel.com/docs/7.x/pagination
https://laravel.com/docs/7.x/pagination#customizing-the-pagination-view

                            
## Gerar templates de paginação

php artisan vendor:publish --tag=laravel-pagination

E então ir para

resources\views\vendor\pagination\default.blade.php

Ou escolher outro template

## Na view

{{ $clientes->links('vendor.pagination.default') }}

Métodos disponíveis
```php
    $results->count()
    $results->currentPage()
    $results->firstItem()
    $results->hasMorePages()
    $results->lastItem()
    $results->lastPage() (Not available when using simplePaginate)
    $results->nextPageUrl()
    $results->onFirstPage()
    $results->perPage()
    $results->previousPageUrl()
    $results->total() (Not available when using simplePaginate)
    $results->url($page)
```
## Link
```php
{{ $clientes->links('vendor.pagination.tailwind') }}
                            <div class="pagination-wrapper"> {!! $clientes->appends(['search' => Request::get('search')])->render() !!} </div>
```
