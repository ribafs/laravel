# Para usar o adminer sem senha para o mysql

## Baixar o source code

https://www.adminer.org/#download

## Descompactar o adminer-4.7.7.zip e copiar a pasta para o diretório web

## Editar o adminer-4.7.7/adminer/index.php e adicionar ao início do arquivo a função adminer_object()

A senha "root" é apenas para o adminer, pois o mysql está configurado para não pedir senha
```php
<?php
/** Adminer - Compact database management
* @link https://www.adminer.org/
* @author Jakub Vrana, https://www.vrana.cz/
* @copyright 2007 Jakub Vrana
* @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
* @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
*/

include "./include/bootstrap.inc.php";
include "./include/tmpfile.inc.php";

$enum_length = "'(?:''|[^'\\\\]|\\\\.)*'";
$inout = "IN|OUT|INOUT";

function adminer_object() {
	include_once "../plugins//plugin.php";
	include_once "../plugins/login-password-less.php";
	return new AdminerPlugin(array(
		// TODO: inline the result of password_hash() so that the password is not visible in source codes
		new AdminerLoginPasswordLess(password_hash("root", PASSWORD_DEFAULT)),
	));
}
... restante do arquivo
```
## Chamar pelo navegador

http://localhost/adminer-4.7.7/adminer

Entrar com
```php
login - root
senha - root
```
Enenda que o mysql/maraidb foi configurado para ser usado sem senha, esta senha "root" é apenas para driblar o adminer.

