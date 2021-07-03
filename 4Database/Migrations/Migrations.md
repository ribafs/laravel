# Migrations

Migrations são arquivos com classes que descrevem estrutura de tabela.

Ele cria a tabela no banco de dados, por isso o banco já deve estar previamente configurado no .env antes de executar o migrate

As migrations ficam no diretório /database/migrations

## Uma migration pode conter várias tabelas, mas não é uma boa prática

## Criar a migrate já com a estrutura básica, usando --create

php artisan make:migration create_vendedores_table --create=vendedores
```php
    public function up()
    {
        Schema::create('vendedores', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
    }
```
## Após executar editar o arquivo criado em database/migrations adicionar os campos restantes

Abrir o arquivo e criar os campos no método up:
```php
	Schema::create('vendedores', function(Blueprint $table){
		$table->increments('id');
		$table->string('name', 50);
		$table->string('email', 100)->unique();
		$table->timestamps();
		$table->softDeletes(); //só marca para deleção
	});
```
Ao final do arquivo ferifique que existe um método down(). Atualize-o adequadamente o método down()
```php
    public function down()
    {
        Schema::dropIfExists('vendedores');
    }
```
##Após salvar execute para a criação da tabela vendedores

php artisan migrate

Agora pode verificar no gerenciador de bancos de dados a tabela criada

## Criar model Cliente, migrations e também controller e com --resource

php artisan make:model Cliente -mcr

## Criar somente model e migration

php artisan make:model Cliente -m

## Criar somente o controller

php artisan make:controller Cliente

## Criar somente o model

php artisan make:model Cliente

## Excluir tabelas do banco e recriar com a mirations existente
```php
php artisan migrate:reset
php artisan migrate:fresh
php artisan migrate:rollback
```
## Chave Estrangeira

O campo da relação deve ser do mesmo tipo, tamanho e ainda unsigned()

ou

>unsignedInteger('campo')

Clientes
```php
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email');
            $table->unsignedBigInteger('companhia_id')->nullable();// Atentar para o unsigned
            $table->timestamps();

            $table->foreign('companhia_id')->references('id')->on('companhias')->onDelete('cascade');
        });
  }

    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('clientes');
        Schema::enableForeignKeyConstraints();
    }


Companhias
    public function up()
    {
        Schema::create('companhias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->timestamps();
        });
    }

$table->foreign('author_id')->references('id')->on('authors');

$table->foreign('author_id')
->references('id')
->on('authors')
->onDelete('cascade');

$table->integer('book_id')->unsigned();
$table->integer('tag_id')->unsigned();
$table->foreign('book_id')->references('id')->on('books');
$table->foreign('tag_id')->references('id')->on('tags');
```
## Relacionamentos

$table->fireign('user_id')->references('id')->on('users');

## Excluir índices
```php
$table->dropPrimary('authors_id_primary');
$table->dropUnique('authors_email_unique');
$table->dropIndex('books_title_index');
$table->dropForeign('books_author_id_foreign');
```
## Tipos de campos das migrations
```php
$table->id(); 	                Alias of $table->bigIncrements('id').
$table->foreignId('user_id'); 	Alias of $table->unsignedBigInteger('user_id').
$table->bigIncrements('id'); 	Auto-incrementing UNSIGNED BIGINT (primary key) equivalent column.
$table->bigInteger('votes'); 	BIGINT equivalent column.
$table->binary('data'); 	BLOB equivalent column.
$table->boolean('confirmed'); 	BOOLEAN equivalent column.
$table->char('name', 100); 	CHAR equivalent column with a length.
$table->date('created_at'); 	DATE equivalent column.
$table->dateTime('created_at', 0); 	DATETIME equivalent column with precision (total digits).
$table->dateTimeTz('created_at', 0); 	DATETIME (with timezone) equivalent column with precision (total digits).
$table->decimal('amount', 8, 2); 	DECIMAL equivalent column with precision (total digits) and scale (decimal digits).
$table->double('amount', 8, 2); 	DOUBLE equivalent column with precision (total digits) and scale (decimal digits).
$table->enum('level', ['easy', 'hard']); 	ENUM equivalent column.
$table->float('amount', 8, 2); 	FLOAT equivalent column with a precision (total digits) and scale (decimal digits).
$table->geometry('positions'); 	GEOMETRY equivalent column.
$table->geometryCollection('positions'); 	GEOMETRYCOLLECTION equivalent column.
$table->increments('id'); 	Auto-incrementing UNSIGNED INTEGER (primary key) equivalent column.
$table->integer('votes'); 	INTEGER equivalent column.
$table->ipAddress('visitor'); 	IP address equivalent column.
$table->json('options'); 	JSON equivalent column.
$table->jsonb('options'); 	JSONB equivalent column.
$table->lineString('positions'); 	LINESTRING equivalent column.
$table->longText('description'); 	LONGTEXT equivalent column.
$table->macAddress('device'); 	MAC address equivalent column.
$table->mediumIncrements('id'); 	Auto-incrementing UNSIGNED MEDIUMINT (primary key) equivalent column.
$table->mediumInteger('votes'); 	MEDIUMINT equivalent column.
$table->mediumText('description'); 	MEDIUMTEXT equivalent column.
$table->morphs('taggable'); 	Adds taggable_id UNSIGNED BIGINT and taggable_type VARCHAR equivalent columns.
$table->uuidMorphs('taggable'); 	Adds taggable_id CHAR(36) and taggable_type VARCHAR(255) UUID equivalent columns.
$table->multiLineString('positions'); 	MULTILINESTRING equivalent column.
$table->multiPoint('positions'); 	MULTIPOINT equivalent column.
$table->multiPolygon('positions'); 	MULTIPOLYGON equivalent column.
$table->nullableMorphs('taggable'); 	Adds nullable versions of morphs() columns.
$table->nullableUuidMorphs('taggable'); 	Adds nullable versions of uuidMorphs() columns.
$table->nullableTimestamps(0); 	Alias of timestamps() method.
$table->point('position'); 	POINT equivalent column.
$table->polygon('positions'); 	POLYGON equivalent column.
$table->rememberToken(); 	Adds a nullable remember_token VARCHAR(100) equivalent column.
$table->set('flavors', ['strawberry', 'vanilla']); 	SET equivalent column.
$table->smallIncrements('id'); 	Auto-incrementing UNSIGNED SMALLINT (primary key) equivalent column.
$table->smallInteger('votes'); 	SMALLINT equivalent column.
$table->softDeletes('deleted_at', 0); 	Adds a nullable deleted_at TIMESTAMP equivalent column for soft deletes with precision (total digits).
$table->softDeletesTz('deleted_at', 0); 	Adds a nullable deleted_at TIMESTAMP (with timezone) equivalent column for soft deletes with precision (total digits).
$table->string('name', 100); 	VARCHAR equivalent column with a length.
$table->text('description'); 	TEXT equivalent column.
$table->time('sunrise', 0); 	TIME equivalent column with precision (total digits).
$table->timeTz('sunrise', 0); 	TIME (with timezone) equivalent column with precision (total digits).
$table->timestamp('added_on', 0); 	TIMESTAMP equivalent column with precision (total digits).
$table->timestampTz('added_on', 0); 	TIMESTAMP (with timezone) equivalent column with precision (total digits).
$table->timestamps(0); 	Adds nullable created_at and updated_at TIMESTAMP equivalent columns with precision (total digits).
$table->timestampsTz(0); 	Adds nullable created_at and updated_at TIMESTAMP (with timezone) equivalent columns with precision (total digits).
$table->tinyIncrements('id'); 	Auto-incrementing UNSIGNED TINYINT (primary key) equivalent column.
$table->tinyInteger('votes'); 	TINYINT equivalent column.
$table->unsignedBigInteger('votes'); 	UNSIGNED BIGINT equivalent column.
$table->unsignedDecimal('amount', 8, 2); 	UNSIGNED DECIMAL equivalent column with a precision (total digits) and scale (decimal digits).
$table->unsignedInteger('votes'); 	UNSIGNED INTEGER equivalent column.
$table->unsignedMediumInteger('votes'); 	UNSIGNED MEDIUMINT equivalent column.
$table->unsignedSmallInteger('votes'); 	UNSIGNED SMALLINT equivalent column.
$table->unsignedTinyInteger('votes'); 	UNSIGNED TINYINT equivalent column.
$table->uuid('id'); 	UUID equivalent column.
$table->year('birth_year'); 	YEAR equivalent column.
```
## Referências

https://laravel.com/docs/7.0/migrations


## Migrations
```php
Um user pode ter muitas permissions
Um user pode ter muitas roles
Uma role pode ter muitos users e 
Permission pode ter muitos users
```

Algumas anotações importantes

Para implementar o código default do laravel para suportar ACL devemos alterar a migration users, adicionando o campo string('role');
Que conterá as roles: admin, autor, comun, etc como enum?
```php
class AddRoleToUsersTable extends Migration
{

    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
}
```

Precisamos criar um relacionamento many to many no model User
```php
public function up()
    {
       Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email',191)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
    });
}

    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name'); // edit posts
            $table->string('slug'); //edit-posts
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('permissions');
    }

    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name'); // edit posts
            $table->string('slug'); //edit-posts
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('roles');
    }
```
Tabela pivo
```php
php artisan make:migration create_users_permissions_table --create=users_permissions

    public function up()
    {
        Schema::create('users_permissions', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('permission_id');

            //FOREIGN KEY CONSTRAINTS
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
 
            //SETTING THE PRIMARY KEYS
            $table->primary(['user_id','permission_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('users_permissions');
    }

php artisan make:migration create_users_roles_table --create=users_roles

    public function up()
    {
        Schema::create('users_roles', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('role_id');

         //FOREIGN KEY CONSTRAINTS
           $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
           $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');

         //SETTING THE PRIMARY KEYS
           $table->primary(['user_id','role_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('users_roles');
    }
```
Under a particular Role, User may have specific Permission

For example, a user may have the permission for post a topic, and an admin may have the permission to edit or delete a topic. In this case, let’s setup a new table for roles_permissions to handle this complexity.
```php
php artisan make:migration create_roles_permissions_table --create=roles_permissions

    public function up()
    {
        Schema::create('roles_permissions', function (Blueprint $table) {
             $table->unsignedInteger('role_id');
             $table->unsignedInteger('permission_id');

             //FOREIGN KEY CONSTRAINTS
             $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
             $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');

             //SETTING THE PRIMARY KEYS
             $table->primary(['role_id','permission_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('roles_permissions');
    }

php artisan migrate
```
