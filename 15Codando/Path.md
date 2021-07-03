# Path

```php
config_path('app.php')

public_path(); // Path of public/

Exemplo:
File::copy(base_path('vendor/ribafs/laravel-acl/up/User.php'), app_path('Models/User.php'));

base_path(); // Path of application root

base_path('database'); // Database

database_path('/migrations')

database_path('/seeds')

resource_path('/views/errors')

storage_path(); // Path of storage/

app_path(); // Path of app/

// Path to the project's root folder 
echo base_path();

// Path to the 'app' folder 
echo app_path();

// Path to the 'public' folder 
echo public_path();

// Path to the 'storage' folder 
echo storage_path();

// Path to the 'storage/app' folder
echo storage_path('app');

$this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'ribafs');
$this->loadViewsFrom(__DIR__.'/../resources/views', 'ribafs');
$this->loadMigrationsFrom(__DIR__.'/../database/migrations');
$this->loadRoutesFrom(__DIR__.'/routes.php');

```

