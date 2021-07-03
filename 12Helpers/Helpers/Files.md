# Relação dos métodos da classe File com exemplos

$file = '/var/www/html/index.php';

#### readFile($file){

Retorna o conteúdo completo de um arquivo
```php
File::readFile($file)
```
#### readFileLine($file, $lineNumber){

Retorna o conteúdo de uma linha de um arquivo
```php
File::readFileLine($file, 3)
```
#### fileCountLines($file){

Conta o número de linhas de um arquivo
```php
File::fileCountLines()
```
#### readInverseFile($file){

Ler de forma inversa (Do final para o começo) um arquivo, linha a linha
```php
File::readInverseFile($file)
```
#### isFileReadable($file){

Checar se arquivo pode ser lido pelo Apache
```php
File::isFileReadable($file)
```
#### isFileWritable($file){

Checar se arquivo tem permissão de escrita para o Apache
```php
File::isFileWritable($file)
```
#### Zip($source, $destination)

Compacta uma pasta recursivamente.
```php
File::Zip('/backup/www/testes', '/backup/www/resultado.zip')
```
#### folderCopy( $source, $target ) {

Copiar uma pasta com todos os arquivos e subpastas recursivamente
```php
File::folderCopy( '/var/www/html/joomla', /var/www/html/jom )
```
#### fileDelete($file){

Excluir um arquivo. Entrar com path full (/var/www/html/src.php) ou relativo ('../src.php')
```php
File::fileDelete($file)
```
#### makeDir($dir){

Criar um novo diretório. Entrar com path full (/var/www/html/dir1) ou relativo ('../dir1')
```php
File::makeDir('/var/www/html/portal')
```
#### currentFile(){

Retornar o nome do arquivo atual
```php
File::currentFile()
```
#### currentDir(){

Retornar o nome do diretório atual
```php
File::currentDir()
```
#### dirSize(string $directory) {

Retorna o tamanho de um diretório recursivamente em Bytes, KB, MB ou GB dependendo do tamanho
```php
print File::dirSize('/var/www/html/joomla');
```   

