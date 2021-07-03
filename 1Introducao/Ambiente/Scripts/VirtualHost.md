# Criação de um vistualhost no apache2

Adaptado de: https://www.vivaolinux.com.br/topico/Apache-Web-Server/virtualHost

Muito útil para quem precisa executar um site no raiz web e que precisa de vários sites, todos no raiz.

Usarei a pasta

/backup/www

Criar pasta
mkdir /backup

```bash
sudo nano /etc/hosts

127.0.0.1	backup
```

Adicionar seu user para o www-data
```bash
addiser ribafs www-data

sudo nano /etc/apache2/sites-available/backup.conf

<VirtualHost *:80>
ServerAdmin ribafs@gmail.com
ServerName backup
DirectoryIndex index.php
DocumentRoot /home/ribafs/www
LogLevel warn
ErrorLog ${APACHE_LOG_DIR}/error.log
CustomLog ${APACHE_LOG_DIR}/access.log combined
<Directory /backup/www/>
    Options Indexes FollowSymLinks
    AllowOverride All
    Require all granted
    DirectoryIndex index.html index.php
</Directory>
</VirtualHost>

sudo a2ensite backup
sudo systemctl reload apache2
```
Para acessar

http://backup

