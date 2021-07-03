# Join no laravel

## Atenção

Quando você faz um join sem especificar as colunas em SELECT, ele inclui TODAS as colunas de TODAS as tabelas participantes (a de FROM e a de JOINs). Sendo assim, haveria teoricamente dois created_at. Se não me engano é priorizado sempre o último. Minha sugestão é você definir as colunas, sendo possível vc definir a tabela principal seguido de um asterisco. David Rodrigues no grupo Laravel Brasil.

```php
Event::select('events.*')
    ->join('client_event', 'events.id', '=', 'client_event.event_id')
    ->join('client_user', 'client_event.client_id', '=', 'client_user.client_id')
    ->where('client_user.user_id', '=', $user_id)
    ->get();


public function events {
        $query = Event::query()
            ->distinct()
            ->selectRaw( 'events.*' )
            ->join( 'client_event', 'client_event.event_id', '=', 'events.id' )
            ->join( 'clients', 'client_event.client_id', '=', 'clients.id' )
            ->join( 'client_user', 'client_user.client_id', '=', 'clients.id' );

        return new HasMany( $query, $this, 'client_user.user_id', 'id' );
    }
```

Laravel Join Query (Left Join, Inner Join, Right Join, Cross Join) Example

Hello Artisan 

In this tutorial i will discuss about laravel left join multiple conditions. I will show you how we can write laravel left join query. Using this article you can learn how to join laravel join two tables. 

Sometimes we need to join multiple table in Laravel. Suppose we need to join product table with category. In laravel we can do it in two ways. One is eloquent relationship and other is join with laravel query builder.

So by this following laravel left join tutorial you will learn how to display data from two tables in laravel. So let's start out Laravel left join example tutorial. 
Inner Join Clause

The query builder sometimes may also be used to write join statements. To perform a simple basic "inner join", you should use the join method on a query builder instance.
```php
$users = DB::table('users')
            ->join('contacts', 'users.id', '=', 'contacts.user_id')
            ->join('orders', 'users.id', '=', 'orders.user_id')
            ->select('users.*', 'contacts.phone', 'orders.price')
            ->get();

```
 
Left Join / Right Join Clause

If you want to perform a "left join" or "right join" instead of an "inner join", use the leftJoin or rightJoin methods. These methods have the same signature as the join method:
```php
$users = DB::table('users')
            ->leftJoin('posts', 'users.id', '=', 'posts.user_id')
            ->get();

$users = DB::table('users')
            ->rightJoin('posts', 'users.id', '=', 'posts.user_id')
            ->get();

```
 
Cross Join Clause

To perform a "cross join" use the crossJoin method with the name of the table you wish to cross join to. Cross joins generate a cartesian product between the first table and the joined table:
```php
$sizes = DB::table('sizes')
            ->crossJoin('colors')
            ->get();
```

Hope this laravel join tutorial can help you.

https://www.codechief.org/article/laravel-join-query-left-join-inner-join-right-join-cross-join-example#gsc.tab=0

