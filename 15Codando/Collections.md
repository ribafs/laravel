# Laravel Check If Value Exists in Collection Example

In this tute, we will discuss laravel eloquent collection contains. i would like to show you laravel eloquent if contains. This article will give you simple example of laravel collection containsStrict example. you can see laravel collection check if empty.

I will give you some examples of how to check value is exists or not in collection in laravel. you can easily add array in laravel 5, laravel 6 and laravel 7.

Let's see example:

Example 1: Laravel Collection Contains Example
```php
public function index()
{
    $collection = collect([
            'Mumbai',
            'New York',
            'London',
            'Rajkot'
        ]);
   
    $collection->contains('Rajkot');  /* true */

    $collection->contains('Paris');   /* false */
}
```
Example 2: Laravel Collection Contains with Key Value Check
```php
public function index()
{
    $collection = collect([
            ['id'=>1, 'name'=>'Hardik'],
            ['id'=>2, 'name'=>'Vimal'],
            ['id'=>3, 'name'=>'Harshad'],
            ['id'=>4, 'name'=>'Harsukh'],
        ]);
  
    $collection->contains('name', 'Harshad'); /* true */
  
    $collection->contains('name', 'Mahesh'); /* false */
}
```

Example 3: Laravel Eloquent with Collection Contains
```php
public function index()
{
    Product::create(['name'=>'Silver', 'price'=>150]);
    Product::create(['name'=>'Bronze', 'price'=>250]);
    Product::create(['name'=>'Gold', 'price'=>50]);
    Product::get()->contains('name', 'Gold'); /* true */
    Product::get()->contains('name', 'Red');  /* false */
    Product::get()->contains('price', 50);  /* true */
}
```
Example 4: Laravel Collection Contains with function
```php
public function index()
{
    Product::create(['name'=>'Silver', 'price'=>150]);
    Product::create(['name'=>'Bronze', 'price'=>250]);
    Product::create(['name'=>'Gold', 'price'=>50]);
    Product::get()->contains(function($key, $value) {
        return $value->price > 100;
    }); // true

}
```
Example 5: Laravel Collection Contains with function
```php
public function index()
{
    $collection = collect([100, 150, 200, 250, 300]);
    $collection->containsStrict('150');  /* false */
    $collection->containsStrict(150);  /* true */
}
```
I hope it can help you...

https://hdtuto.com/article/laravel-check-if-value-exists-in-collection-example

