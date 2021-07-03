# Laravel-zero

https://laravel-zero.com/docs/installation/
```php
composer global require "laravel-zero/installer"

laravel-zero new app
```
ou
```php
composer create-project --prefer-dist laravel-zero/laravel-zero app
```
Renomear a app

php application app:rename [app]

Using the app:install Artisan command you can install the database component:
```php
php <your-app-name> app:install database
```
As you might have already guessed, it is Laravel's Eloquent component that works like a breeze in the Laravel Zero environment too.

Usage:
```php
use DB;

DB::table('users')->insert(
    ['email' => 'enunomaduro@gmail.com']
);

$users = DB::table('users')->get();
```
Laravel Database Migrations, database factories, and Database Seeding features are also included.


## Filesystem

If you want to move files in your system, or to different providers like AwsS3 and Dropbox. By default, Laravel Zero ships with the Filesystem component of Laravel.

Note: By default the root directory is your-app-name/storage.

    Writing files after you build your application is different, check Writing files in production

Using the Storage facade
```php
use Storage;

Storage::put("reminders.txt", "Task 1");
```
Using the File facade
```php
use Illuminate\Support\Facades\File;

File::put("/path/to/file/reminders.txt", "Task 1");
```
Writing files in production

When using the filesystem be aware that when you build the application with app:build you create a .phar file. You can not add, update or delete files inside the .phar file.

    We are currently looking into streamlining the filesystem access. The code below is an example of how you can currently write files from the built application to the current working directory.

With the Storage facade

If you want to use the Storage facade you will need to use a config file, similar to how Laravel does it.

    Create a file filesystems.php in your config/ directory.
    Copy and paste the following contents. This code will replace the default your-app-name/storage/app folder with the current working directory.
```php
<?php

return [
    'default' => 'local',
    'disks' => [
        'local' => [
            'driver' => 'local',
            'root' => getcwd(),
        ],
    ],
];
```
    Use the Storage facade like you would before.

With the File facade

Using the File facade is just the same as normal
```php
File::put( getcwd() . DIRECTORY_SEPARATOR . "reminders.txt", "Task 1");
```

Create a logo

Using the app:install Artisan command you can install the logo component:
```php
php <your-app-name> app:install logo
```
Just after installation, if you run php <your-app-name> your application will contain a ASCII logo:

This command will install dependencies needed and publishes a config file under config/logo.php.
Using a different font

Under the hood the logo component uses the laminas/laminas-text package which renders text using fonts called "figlets".

By default Laravel Zero uses the big.flf FIGlet file by Glenn Chappell. Additional FIGlet files can be downloaded from figlet.org or created using FIGlet editing software.

Once a font has been downloaded, the logo.font value can be set in the config to provide the full path to the FIGlet file.
```php
// config/logo.php
-  'font' => \LaravelZero\Framework\Components\Logo\FigletString::DEFAULT_FONT,
+  'font' => resources_path('fonts/doom.flf'),
```
For more details, check out the Laminas docs on FIGlets.


## Build interactive menus

Using the app:install Artisan command you can install the menu component:
```php
php <your-app-name> app:install menu
```
Interactive menus in console applications are very powerful. They provide a simple interface that requires little interaction. With Laravel Zero, you can use the menu method to create beautiful menus:

Using menus in the console may sound silly, but is fantastic! Your users don't need to type the number corresponding to their choice any more. They can just use the arrows on their keyboard to make their selection!

Example

Create your first menu by copy pasting the code below in your commands handle function.
```php
$option = $this->menu('Pizza menu', [
    'Freshly baked muffins',
    'Freshly baked croissants',
    'Turnovers, crumb cake, cinnamon buns, scones',
])->open();

$this->info("You have chosen the option number #$option");
```
When you now run your command your output should be similar to this image:

Changing the appearance

The appearance of the menu can be set with a fluent API. What if we like a green font on a black background? The code below shows you how to do just that and some extras.
```php
$this->menu($title, $options)
    ->setForegroundColour('green')
    ->setBackgroundColour('black')
    ->setWidth(200)
    ->setPadding(10)
    ->setMargin(5)
    ->setExitButtonText("Abort")
    // remove exit button with
    // ->disableDefaultItems()
    ->setUnselectedMarker('❅')
    ->setSelectedMarker('✏')
    ->setTitleSeparator('*-')
    ->addLineBreak('<3', 2)
    ->addStaticItem('AREA 2')
    ->open();
```
    Behind the scenes, the menu method uses the nunomaduro/laravel-console-menu package. You can find more details on how to use the menu method there.


Send desktop notifications

Laravel Zero provides a notify method that gives the power of sending desktop notifications from your Artisan command:
```php
$this->notify("Hello Web Artisan", "Love beautiful..", "icon.png");
```
The code above will generate the following notification in your desktop:

Get more details: 

https://github.com/nunomaduro/laravel-desktop-notifier.


## Web Browser Automation

Using the app:install Artisan command you can install the console-dusk component:
```php
php <your-app-name> app:install console-dusk
```
The Console Dusk allows the usage of Laravel Dusk in Artisan commands. Horever, in Laravel Zero you can use Laravel Dusk for web tasks that should be automated. 
Let's take a look at the usage:
```php
class VisitLaravelZeroCommand extends Command
{
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->browse(function ($browser) {
            $browser->visit('http://laravel-zero.com')
                ->assertSee('Collision');
        });
    }
}
```
Output example:

Get more details: https://github.com/nunomaduro/laravel-console-dusk.


Build a standalone application

Your Laravel Zero project, by default, allows you to build a standalone PHAR archive to ease the deployment or distribution of your project.
```php
php your-app-name app:build <your-build-name>
```
The build will provide a single phar archive, ready to use, containing all the code of your project and its dependencies. You will then be able to execute it directly:
```php
./builds/<your-build-name>
```
or on Windows:
```php
C:\application\path> php builds\<your-build-name>
```
We use humbug/box to provide fast application bundling. In order to configure your build, you should take a look at the file box.json.

Please check the box documentation to understand all options: github.com/humbug/box/blob/master/doc/configuration.md.

Non-interactive build

When you build you get asked about build version, in case you want to skip this step you can provide the build version as an option:

php your-app-name app:build --build-version=<your-build-version>

Self update

Using the app:install Artisan command you can install the self-update component:
```php
php <your-app-name> app:install self-update
```
This component will add an Artisan self-update command to every build application. This command will try to download the latest version from GitHub, if available.

Custom update strategies

The self-updater supports custom "strategies" to configure how the application is updated. By default it uses the GithubStrategy which will try to download the PHAR binary from a builds/ directory in the GitHub source repository.

Custom strategies must implement the following StrategyInterface interface.

By default, a few strategies are provided in Laravel Zero:
```php
    Download the PHAR file from the builds/ directory on GitHub:
    LaravelZero\Framework\Components\Updater\Strategy\GitHubStrategy
    Download the PHAR file from GitHub releases assets:
    LaravelZero\Framework\Components\Updater\Strategy\GitHubReleasesStrategy
```
To use a custom strategy, first publish the config using:
```php
php <your-app-name> vendor:publish --provider "LaravelZero\Framework\Components\Updater\Provider"
```
Then update the updater.strategy value in the configuration file to use the required class name.

Environment Variables

If the dotenv component is installed, you can place a .env file in the same folder as the build application to make Laravel Zero load environment variables from that same file.

Database

To use SQLite in your standalone PHAR application, you need to tell Laravel Zero where to place the database in a production environment.

Similar to Laravel, this is configured in config/database.php under the connections.sqlite.database key. By default this is set to database_path('database.sqlite') which resolves to <project>/database/database.sqlite. Since we can't modify files within the project once the PHAR is built, we need to store this somewhere on the users computer. A good choice for this would be to create a "dot" folder inside your users home folder. For example:
```php
// config/database.php
'connections' => [
  'sqlite' => [
      'driver' => 'sqlite',
      'url' => env('DATABASE_URL'),
-     'database' => database_path('database.sqlite'),
+     'database' => $_SERVER['HOME'] . '/.your-project-name/database.sqlite',
      'prefix' => '',
      'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
  ],
]
```
In this case it would tell Laravel to use the database at /Users/<username>/.your-project-name/database.sqlite (for MacOS).

It is important to note that this file will not exist upon installation of your app so you will either need to ensure it exists and is migrated before using the database or provide an install command which creates the database and migrates it.

