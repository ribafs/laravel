# Relaciionamentos em models
```php
<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Category extends Model
{
    protected $fillable = [
        'name'
    ];
	
	/**
     * Get the products for the category.
     */
    public function products()
    {
        return $this->hasMany('App\Product');
    }
}
?>

<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Product extends Model
{
    /**
     * Get the category that owns the product.
     */
    public function category()
    {
        return $this->belongsTo('App\Category');
    }
}

?>

<?php
Route::get('/', function () {
    return view('welcome');
});
 
Route::get('product','productsController@index');

<?php
namespace App\Http\Controllers;
use App\Product;
use App\Category;
use Illuminate\Http\Request;
class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get Products data
        $product = Category::find(1)->products;
	dd($product);
		
	//get categories data
	$category = Product::find(1)->category;
	dd($category);
    }

}
?>
```
https://xpertphp.com/laravel-one-to-many-eloquent-relationship-tutorial-example/
