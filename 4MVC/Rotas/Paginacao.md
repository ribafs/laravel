# Paginação em rotas
```php
    // routes file
    Route::get('products', function () {
        return view('products.index')
            ->with('products', Product::paginate(20));
    });

    // resource/views/products/index.blade.php
    @foreach ($products as $product)
        <!-- show the product details -->
    @endforeach
    {!! $products->links() !!}

php artisan vendor:publish --tag=laravel-pagination

Route::get('custom-pagination','ProductController@index');

class ProductController extends Controller
{
    public function index(Request $request){     
      $products=Product::paginate(5);
      return view('products',compact('products'))->with('i', ($request->input('page', 1) - 1) * 5);
    }
}

    <!DOCTYPE html>
    <html>
    <head>
        <title>Customizing pagination templates with example in Laravel 5.3</title>
        <link rel="stylesheet" type="text/css" href="http://www.expertphp.in/css/bootstrap.css">
    </head>
    <body>
    <div class="container">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr class="heading">
                    <th>No</th>
                    <th>Name</th>
                    <th>Details</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ ++$i }}</td>
                            <td>{!! $product->name !!}</td>
                            <td>{!! $product->details !!}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {!! $products->links('pagination') !!}
        </div>
    </div>
    </body>
    </html>
```
http://expertphp.in/laravel5.3/public/custom-pagination
