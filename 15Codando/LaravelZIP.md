# How to Create ZIP Archive with Files And Download it in Laravel

March 5, 2019

If you need your users to be able to download multiple files at once, it’s better to create one archive and let them download it. Here’s how to do it in Laravel.

In fact, it’s less about Laravel and more about PHP, we will be using ZipArchive class that existed since PHP 5.2. To use that, make sure your php.ini has enabled extension called ext-zip.

Task 1. Archive user’s invoice from storage/invoices/aaa001.pdf

Here’s the code:
```php
$zip_file = 'invoices.zip'; // Name of our archive to download

// Initializing PHP class
$zip = new \ZipArchive();
$zip->open($zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

$invoice_file = 'invoices/aaa001.pdf';

// Adding file: second parameter is what will the path inside of the archive
// So it will create another folder called "storage/" inside ZIP, and put the file there.
$zip->addFile(storage_path($invoice_file), $invoice_file);
$zip->close();

// We return the file immediately after download
return response()->download($zip_file);
```
That’s it, nothing too difficult, right?

Task 2. Archive all files in a folder storage/invoices

Nothing changes from Laravel side, we will just add some more plain PHP code for iterating the files.
```php
$zip_file = 'invoices.zip';
$zip = new \ZipArchive();
$zip->open($zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

$path = storage_path('invoices');
$files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));
foreach ($files as $name => $file)
{
    // We're skipping all subfolders
    if (!$file->isDir()) {
        $filePath     = $file->getRealPath();

        // extracting filename with substr/strlen
        $relativePath = 'invoices/' . substr($filePath, strlen($path) + 1);

        $zip->addFile($filePath, $relativePath);
    }
}
$zip->close();
return response()->download($zip_file);
```
We’re done here. You see, you don’t need any Laravel packages to achieve this.

Saying that, if you use Spatie Media Library, they have a special class for it, called MediaStream.

https://laraveldaily.com/how-to-create-zip-archive-with-files-and-download-it-in-laravel/

