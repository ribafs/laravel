# Métodos customizados auxiliares
```php
    private function writeFile($file, $content){
        $fp = fopen($file, "w");
        fwrite($fp, $content); // grava a string no arquivo. Se não existir será criado
        fclose($fp);
    }

    private function clear(){
      if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
          system('cls');
      } else {
          system('clear');
      }
    }
```
Usando no handle():
```php
$this->clear();
```
