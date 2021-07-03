# Helpers do Laravel 8

use Illuminate\Support\Str;

Exemplo de uso

$rand = Str::random(60);

use Illuminate\Support\Facades\File;

use Illuminate\Support\Arr;

$array = Arr::add(['name' => 'Desk', 'price' => 100);

The Arr::exists method checks that the given key exists in the provided array:

use Illuminate\Support\Arr;

$array = ['name' => 'John Doe', 'age' => 17];

$exists = Arr::exists($array, 'name');

Arr::first()

The Arr::first method returns the first element of an array passing a given truth test:

use Illuminate\Support\Arr;

$array = [100, 200, 300];

$first = Arr::first($array, function ($value, $key) {
    return $value >= 150;
});

Arr::last()

The Arr::last method returns the last element of an array passing a given truth test:

use Illuminate\Support\Arr;

$array = [100, 200, 300, 110];

$last = Arr::last($array, function ($value, $key) {
    return $value >= 150;
});

Arr::random()

The Arr::random method returns a random value from an array:

use Illuminate\Support\Arr;

$array = [1, 2, 3, 4, 5];

$random = Arr::random($array);

Arr::sort()

The Arr::sort method sorts an array by its values:

use Illuminate\Support\Arr;

$array = ['Desk', 'Table', 'Chair'];

$sorted = Arr::sort($array);

last()

The last function returns the last element in the given array:

$array = [100, 200, 300];

$last = last($array);


Strings

Str::between()

The Str::between method returns the portion of a string between two values:

use Illuminate\Support\Str;

$slice = Str::between('This is my name', 'This', 'name');

Str::camel()

The Str::camel method converts the given string to camelCase:

use Illuminate\Support\Str;

$converted = Str::camel('foo_bar');

Str::contains()

The Str::contains method determines if the given string contains the given value (case sensitive):

use Illuminate\Support\Str;

$contains = Str::contains('This is my name', 'my');

Str::finish()

The Str::finish method adds a single instance of the given value to a string if it does not already end with the value:

use Illuminate\Support\Str;

$adjusted = Str::finish('this/string', '/');

// this/string/

$adjusted = Str::finish('this/string/', '/');

Str::length()

The Str::length method returns the length of the given string:

use Illuminate\Support\Str;

$length = Str::length('Laravel');

Str::limit()

The Str::limit method truncates the given string at the specified length:

use Illuminate\Support\Str;

$truncated = Str::limit('The quick brown fox jumps over the lazy dog', 20);

Str::lower()

The Str::lower method converts the given string to lowercase:

use Illuminate\Support\Str;

$converted = Str::lower('LARAVEL');

Str::plural()

The Str::plural method converts a single word string to its plural form. This function currently only supports the English language:

use Illuminate\Support\Str;

$plural = Str::plural('car');

// cars

$plural = Str::plural('child');



Str::random()

The Str::random method generates a random string of the specified length. This function uses PHP's random_bytes function:

use Illuminate\Support\Str;

$random = Str::random(40);

Str::singular()

The Str::singular method converts a string to its singular form. This function currently only supports the English language:

use Illuminate\Support\Str;

$singular = Str::singular('cars');

// car

$singular = Str::singular('children');

Str::snake()

The Str::snake method converts the given string to snake_case:

use Illuminate\Support\Str;

$converted = Str::snake('fooBar');

Str::substr()

The Str::substr method returns the portion of string specified by the start and length parameters:

use Illuminate\Support\Str;

$converted = Str::substr('The Laravel Framework', 4, 7);

Str::ucfirst()

The Str::ucfirst method returns the given string with the first character capitalized:

use Illuminate\Support\Str;

$string = Str::ucfirst('foo bar');

Str::upper()

The Str::upper method converts the given string to uppercase:

use Illuminate\Support\Str;

$string = Str::upper('laravel');


URLs

action()

The action function generates a URL for the given controller action:

$url = action([HomeController::class, 'index']);

If the method accepts route parameters, you may pass them as the second argument to the method:

$url = action([UserController::class, 'profile'], ['id' => 1]);

asset()

The asset function generates a URL for an asset using the current scheme of the request (HTTP or HTTPS):

$url = asset('img/photo.jpg');

You can configure the asset URL host by setting the ASSET_URL variable in your .env file. This can be useful if you host your assets on an external service like Amazon S3:

route()

The route function generates a URL for the given named route:

$url = route('routeName');

If the route accepts parameters, you may pass them as the second argument to the method:

$url = route('routeName', ['id' => 1]);

url()

The url function generates a fully qualified URL to the given path:

$url = url('user/profile');

$url = url('user/profile', [1]);

If no path is provided, an Illuminate\Routing\UrlGenerator instance is returned:

$current = url()->current();

$full = url()->full();

$previous = url()->previous();


Diversos

abort()

The abort function throws an HTTP exception which will be rendered by the exception handler:

abort(403);

auth()

The auth function returns an authenticator instance. You may use it instead of the Auth facade for convenience:

$user = auth()->user();

If needed, you may specify which guard instance you would like to access:

$user = auth('admin')->user();

back()

The back function generates a redirect HTTP response to the user's previous location:

return back($status = 302, $headers = [], $fallback = false);

return back();

bcrypt()

The bcrypt function hashes the given value using Bcrypt. You may use it as an alternative to the Hash facade:

$password = bcrypt('my-secret-password');

cache()

The cache function may be used to get values from the cache. If the given key does not exist in the cache, an optional default value will be returned:

$value = cache('key');

$value = cache('key', 'default');

config()

The config function gets the value of a configuration variable. The configuration values may be accessed using "dot" syntax, which includes the name of the file and the option you wish to access. A default value may be specified and is returned if the configuration option does not exist:

$value = config('app.timezone');

$value = config('app.timezone', $default);

You may set configuration variables at runtime by passing an array of key / value pairs:

config(['app.debug' => true]);

dd()

The dd function dumps the given variables and ends execution of the script:

dd($value);

dd($value1, $value2, $value3, ...);

If you do not want to halt the execution of your script, use the dump function instead.

env()

The env function retrieves the value of an environment variable or returns a default value:

$env = env('APP_ENV');

// Returns 'production' if APP_ENV is not set...
$env = env('APP_ENV', 'production');

now()

The now function creates a new Illuminate\Support\Carbon instance for the current time:

$now = now();

redirect()

The redirect function returns a redirect HTTP response, or returns the redirector instance if called with no arguments:

return redirect($to = null, $status = 302, $headers = [], $secure = null);

return redirect('/home');

return redirect()->route('route.name');

request()

The request function returns the current request instance or obtains an input item:

$request = request();

$value = request('key', $default);

today()

The today function creates a new Illuminate\Support\Carbon instance for the current date:

$today = today();

view()

The view function retrieves a view instance:

return view('auth.login');


Mais em

https://laravel.com/docs/8.x/helpers
