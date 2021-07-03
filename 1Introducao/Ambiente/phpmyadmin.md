# PHPMyAdmin no Linux

sudo apt install phpmyadmin

Por default o phpmyadmin exige senha para o root no linux

Para mudar isso e fazer com que ele aceite sem senha

Editar

sudo nano /etc/phpmyadmin/config.inc.php 

Descomente as duas ocorrências com

AllowNoPassword

E reinie o apache

sudo service apache2 restart

