# Migrations usando os novos métodos:

id()
foreignId()
constrainer()

Estes e outros métodos foram adicionados ao Laravel 7.
```php
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
        });

        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // edit posts
            $table->string('slug'); //edit-posts
            $table->timestamps();
        });

        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // edit posts
            $table->string('slug'); //edit-posts
            $table->timestamps();
        });

        Schema::create('user_permission', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('permission_id');

            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('permission_id')->constrained()->onDelete('cascade');
 
            $table->primary(['user_id','permission_id']);
        });

        Schema::create('user_role', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('role_id');

           $table->foreignId('user_id')->constrained()->onDelete('cascade');
           $table->foreignId('role_id')->constrained()->onDelete('cascade');

           $table->primary(['user_id','role_id']);
        });

        Schema::create('role_permission', function (Blueprint $table) {
             $table->unsignedBigInteger('role_id');
             $table->unsignedBigInteger('permission_id');

             $table->foreignId('role_id')->constrained()->onDelete('cascade');
             $table->foreignId('permission_id')->constrained()->onDelete('cascade');

             $table->primary(['role_id','permission_id']);
        });
```

