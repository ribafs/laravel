# Hash
```php
$user = User::where('user', $request->password)->first();

if(Hash::check($request->password, $user->password)){
  $error_db = 'A senha está errada';
  return view('login', ['error'=>$error_db]);
}
```
