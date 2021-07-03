# QueryBuilder

In your case, you can replace your code
```php
$items = Items::all(['id', 'name']);
```
with
```php
$items = Items::lists('name', 'id');
```
Also, you can chain it with other Query Builder as well.
```php
$items = Items::where('active', true)->orderBy('name')->lists('name', 'id');
```
source: http://laravel.com/docs/5.0/queries#selects

```php
$users = DB::table('users')->select('name', 'email as user_email')->get();


$users = DB::table('users')
            ->join('user_role', 'users.id', '=', 'roles.user_id')
            ->select('users.*', 'roles.slug')
            ->get();

                $users = DB::table('users')
                    ->join('roles', 'users.id', '=', 'roles.id')
                    ->select('users.*', 'roles.slug')
                    ->paginate($perPage);

```

