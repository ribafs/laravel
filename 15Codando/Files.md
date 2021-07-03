Para usar a biblioteca File precisamos adicionar no início da classe:
```php
use Illuminate\Support\Facades\File;

File::copy(from_path, to_path);

File::copyDirectory(__DIR__.'/form-directory', resource_path('to-directory'));

mix.copyDirectory(__DIR__.'/form-directory', resource_path('to-directory'));

ou
\File::copyDirectory( public_path . 'to/the/app', resource_path('to/the/app'));

now File::copyDirectory always overwrite files, if it can ignore existing file such as shell cp, it will be better.

$ cp --help
Usage: cp [OPTION]... [-T] SOURCE DEST
Copy SOURCE to DEST, or multiple SOURCE(s) to DIRECTORY.

  -i, --interactive            prompt before overwrite (overrides a previous -n
                                  option)
  -n, --no-clobber             do not overwrite an existing file (overrides
                                 a previous -i option)

framework/src/Illuminate/Filesystem/Filesystem.php

public function copyDirectory($directory, $destination, $options = null) 


File::makeDirectory($path);

        if (!File::exists(app_path('Console/Commands'))){
            File::makeDirectory(app_path('Console/Commands');           
        }

$seeder = base_path('database/seeders/DatabaseSeeder.php');
if(File::exists($seeder)){
    File::copy($seeder), base_path('database/seeders/DatabaseSeederBAK.php'));
    File::copy(base_path('vendor/ribafs/laravel-acl/acl/seeders/DatabaseSeeder.php'), base_path('database/seeders/DatabaseSeeder.php'));
}
$route = base_path('routes/web.php');
if(File::exists($route)){
    File::copy($route), base_path('routes/webBAK.php');
    File::copy(base_path('vendor/ribafs/laravel-acl/acl/web.php'), base_path('routes/web.php'));
}
$wel = base_path('resources/views/welcome.blade.php');
if(File::exists($wel)){
    File::copy($wel), base_path('resources/views/welcome.bladeBAK.php');
    File::copy(base_path('vendor/ribafs/laravel-acl/acl/views/welcome.blade.php'), base_path('resources/views/welcome.blade.php'));
}
$app = base_path('resources/views/welcome.blade.php')
if(File::exists($app)){
    File::copy($wel), base_path('resources/views/welcome.bladeBAK.php');
    File::copy(base_path('vendor/ribafs/laravel-acl/acl/views/layouts/app.blade.php'), base_path('resources/views/layouts/app.blade.php'));
}
```

