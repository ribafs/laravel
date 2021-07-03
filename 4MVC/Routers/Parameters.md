# Parâmetros em Rotas

Route::get('/{age}', function (Request $age) {
    return $age;
});

Route::get('/{age}', [
    'middleware' => 'App\Http\Middleware\CheckAge',
     function () {
        return view('welcome');
}]);

Receber a idade na welcome

Route::get('/{id}/{category}/{name}', [
    'middleware' => DumpMiddleware',
     function () {
        return view('welcome');
}]);

// Route that handles profile comes last
Route::get('/{username}', function() {
    return view('profile');
});


