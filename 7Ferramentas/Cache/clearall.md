# Criar comando com
```php
public function handle()
{
    \Artisan::call('cache:clear');
    $this->info('Application cache is cleared.');
    \Artisan::call('config:clear');
    $this->info('Configuration cache is cleared.');
    \Artisan::call('route:clear');
    $this->info('Route cache is cleared.');
    \Artisan::call('view:clear');
    $this->info('View cache is cleared.');
    \Artisan::call('optimize:clear');
    $this->info('Optimized and cleared.');
    \Artisan::call('config:cache');
    $this->info('Config cached.');
}
```

