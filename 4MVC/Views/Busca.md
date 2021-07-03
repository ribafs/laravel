# Busca no Laravel

Ela é criada no controller e recebida na view
```php
      public function search(Request $request)
      {
         $cari = $request->get('search');
         $data['result']= DB::table('articles')->WHERE('title', 'LIKE', '%' .$cari . '%')->paginate(10);
         return view('/article/show', $data);
      }

       <form class="navbar-form navbar-left" method="GET" action="{{url('search')}}">
        <div class="input-group">
          <input type="text" class="form-control" placeholder="Search" name="search">
            <button class="btn btn-default" type="submit">
              <i class="fa fa-search"></i>
            </button>
        </div>
      </form>
```

Simple and Advanced Search in Laravel 5

by Sam

After we inserted data into our table, we displayed those entries on the browser. Just in case we have hundreds and thousands of records, we need to include search form for faster retrieval of data.

On this tutorial, I have made two options for simple and advanced search in Laravel. If you only have one searchbox, you may need the simple searchbox, if it’s more than one, you might be needing of the advanced feature. Take a look at the guide below.

Search Features

Simple Search
– Search the record of people containing name

Advanced Search
– Name of Person
– Contains an address
– Range of an age
Let’s get started
1. Install Laravel

Open your terminal and download the Laravel Framework by executing the command.

composer create-project --prefer-dist laravel/laravel larasearch

It takes a few minutes to download. Now, go into the larasearch directory.

 cd larasearch 

After that, start your server.

php artisan serve

Open your browser and go to http://localhost:8000

 
2. Configure your .env file

Make sure to configure your .env according to your settings.
```php
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=searchdb
DB_USERNAME=root
DB_PASSWORD=
```
3. Model and Migration

Let’s create a model and migration and the same time. Open your terminal and execute the command below.

 php artisan make:model People -m 

Database Schema

Navigate to database » migrations » create_people_table.php and add  additional fields.
```php
public function up()
{
    Schema::create('people', function (Blueprint $table) {
    $table->increments('id');
    $table->string('name');
    $table->string('address');
    $table->integer('age');
    $table->timestamps();
    });
}
```
Next, go to App » Providers » AppServiceProvider.php
```php
use Illuminate\Support\Facades\Schema;
.
.
public function boot()
{
Schema::defaultStringLength(191);
}
```
Then, execute the migration.

php artisan migrate

After that, add fields as fillable. Go to App  » People.php

protected $fillable = ['name', 'address', 'age']; 

4. Populate People table with data

You can populate data manually so that it will display on your search. But on this tutorial, let’s use laravel factory feature to insert data automatically.

php artisan make:factory Peoplefactory 

Go to database >> factories >> Peoplefactory.php and set the fields to be populated.
```php
$factory->define(App\People::class, function (Faker $faker) {
return [
    'name' => $faker->name,
    'address' => $faker->address,
    'age' => mt_rand(18, 150),
];
});
```
Notice that I added  mt_rand(18, 150). It automatically adds the age between 18 to 150. Then, let’s execute the faker using artisan tinker.
```php
php artisan tinker
>> factory(App\People::class, 50)->create(); 
```
The command above will insert 50 records into your people table. You can now check your table to confirm if data have been successfully inserted.

5. Create Controller

Now, it’s time for us create the controller of our search form. Execute the command below the generate a SearchController.

 php artisan make:controller SearchController 

After that, go to app >> Http >> Controllers >> SearchController.php
```php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
class SearchController extends Controller
{
    public function index()
    {
        $data = \DB::table('people')->paginate(10);
        return view('search', compact('data'));
    }
    public function simple(Request $request)
    {
        $data = \DB::table('people');
        if( $request->input('search')){
            $data = $data->where('name', 'LIKE', "%" . $request->search . "%");
        }
        $data = $data->paginate(10);
        return view('search', compact('data'));
    }
    public function advance(Request $request)
    {
        $data = \DB::table('people');
        if( $request->name){
            $data = $data->where('name', 'LIKE', "%" . $request->name . "%");
        }
        if( $request->address){
            $data = $data->where('address', 'LIKE', "%" . $request->address . "%");
        }
        if( $request->min_age && $request->max_age ){
            $data = $data->where('age', '>=', $request->min_age)
                         ->where('age', '<=', $request->max_age);
        }
        $data = $data->paginate(10);
        return view('search', compact('data'));
    }
}
```
6. Configure your Routing

Now, we have to set the routing of our application.
```php
Route::get('/people', 'SearchController@index');
Route::get('/people/simple', 'SearchController@simple')->name('simple_search');
Route::get('/people/advance', 'SearchController@advance')->name('advance_search');
```
7. Create blade for search

Lastly, we need to display the data into our view.

From your resources folder, create search.blade.php and copy the codes below.
```php
<!DOCTYPE html>
<html>
<head>
<title>Laravel Search</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<div class="container">
<div class="row">
<div class="col-md-4">
<h3>Simple Search</h3><br>
<form action="{{ route('simple_search') }}" method="GET">
<div class="input-group mb-3">
<input type="text" class="form-control" placeholder="Type the name" aria-describedby="basic-addon2" name="search">
<div class="input-group-append">
<button class="btn btn-secondary" type="submit">Search</button>
</div>
</div>
</form>
<form action="{{ route('advance_search') }}" method="GET">
<h3>Advanced Search</h3><br>
<input type="text" name="name" class="form-control" placeholder="Person's name"><br>
<input type="text" name="address" class="form-control" placeholder="Address"><br>
<label>Range of Age</label>
<div class="input-group">
<input type="text" name="min_age" class="form-control" placeholder="Start Age">
<input type="text" name="max_age" class="form-control" placeholder="End of Age">
</div><br>
<input type="submit" value="Search" class="btn btn-secondary">
</form>
</div>
<div class="col-md-8">
<h3>List of People</h3>
<table class="table table-striped">
<tr>
<th>ID</th>
<th>Name</th>
<th>Address</th>
<th>Age</th>
</tr>
@foreach($data as $pep)
<tr>
<td>{{ $pep->id }}</td>
<td>{{ $pep->name }}</td>
<td>{{ $pep->address }}</td>
<td>{{ $pep->age }}</td>
</tr>
@endforeach
</table>
{{ $data->appends(request()->except('page'))->links() }}
</div>
</div>
</div>
</body>
</html>
```
Notice that I added a pagination using {{ $data->appends(request()->except('page'))->links() }}. This code is necessary to include the query string whenever the user clicks the pagination link.

And that’s all.

If you have a question, don’t hesitate to ask a question below.
https://www.codespeaker.com/laravel-framework/simple-and-advanced-search-in-laravel-5/


How to add simple search to your Laravel blog/website?
Introduction

There are many ways of adding search functionality to your Laravel website.

For example, you could use Laravel Scout which is an official Laravel package, you can take a look at this tutorial here on how to install, setup and use Laravel scout with Algolia.

However, in this tutorial here, we will focus on building a very simple search method without the need of installing additional packages.
Prerequisites

Before you begin you need to have Laravel installed.

If you do not have that yet, you can follow the steps on how to do that here or watch this video tutorial on how to deploy your server and install Laravel from scratch.

You would also need to have a model ready that you would like to use. For example, I have a small blog with a posts table and Post model that I would be using.
Controller changes

First, create a controller if you do not have one already. In my case, I will name the controller PostsController as it would be responsible for handling my blog posts.

To create that controller just run the following command:

php artisan make:controller PostsController

Then open your controller with your text editor, and add the following search method:
```php
public function search(Request $request){
    // Get the search value from the request
    $search = $request->input('search');

    // Search in the title and body columns from the posts table
    $posts = Post::query()
        ->where('title', 'LIKE', "%{$search}%")
        ->orWhere('body', 'LIKE', "%{$search}%")
        ->get();

    // Return the search view with the resluts compacted
    return view('search', compact('posts'));
}
```
Note that you would need to change the table names which you would like to search in.

In the example above we are searching in the title and body columns from the posts table.
Route changes

Once our controller is ready, we need to add a new route in the web.php file:

Route::get('/search/', 'PostsController@search')-name('search');

We will just use a standard get request and map it to our search method in the PostsController.

## Blade view changes

Now that we have the route and the controller all sorted out, we just need to add a form in our search.blade.php file.

I will use the following simple GET form:
```php
<form action="{{ route('search') }}" method="GET">
    <input type="text" name="search" required/>
    <button type="submit">Search</button>
</form>
```
Feel free to add this to your existing view and style it accordingly with your classes.

Then to display the results, what you could do is use the following forearch loop in your view:
```php
@if($posts->isNotEmpty())
    @foreach ($posts as $post)
        <div class="post-list">
            <p>{{ $post->title }}</p>
            <img src="{{ $post->image }}">
        </div>
    @endforeach
@else 
    <div>
        <h2>No posts found</h2>
    </div>
@endif
```
The above would display your posts if there are any found and would print No posts found message if there are none.

Conclusion

This is just one way of building a simple search Laravel!

If you are just getting started with Laravel I would recommend going through this Laravel introduction course.

Hope that this helps!

https://devdojo.com/bobbyiliev/how-to-add-simple-search-to-your-laravel-blogwebsite


