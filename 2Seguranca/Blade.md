# Algumas tags do blade para controlar acesso

Uso das tags e também do método csrf_field() e o método method_field()
```php
{{ method_field('PATCH') }}
{{ csrf_field() }}

@can('update', $post)
    <!-- The Current User Can Update The Post -->
@elsecan('create', App\Post::class)
    <!-- The Current User Can Create New Post -->
@endcan


@cannot('update', $post)
    <!-- The Current User Cannot Update The Post -->
@elsecannot('create', App\Post::class)
    <!-- The Current User Cannot Create A New Post -->
@endcannot


Usadas em conjunto com o componente Auth

@can('update', $post)
    <!-- The Current User Can Update The Post -->
@elsecan('create', App\Post::class)
    <!-- The Current User Can Create New Post -->
@endcan


@cannot('update', $post)
    <!-- The Current User Cannot Update The Post -->
@elsecannot('create', App\Post::class)
    <!-- The Current User Cannot Create A New Post -->
@endcannot


@canany(['update', 'view', 'delete'], $post)
    // The current user can update, view, or delete the post
@elsecanany(['create'], \App\Post::class)
    // The current user can create a post
@endcanany


@can('create', App\Post::class)
    <!-- The Current User Can Create Posts -->
@endcan

@cannot('create', App\Post::class)
    <!-- The Current User Can't Create Posts -->
@endcannot
```

## Impedindo o acesso ao botão para inserir registro
```php
                @can('product-create')
                <a class="btn btn-success" href="{{ route('products.create') }}"> Create New Product</a>
                @endcan
```
## Impedindo o acesso ao index.blade.php

        @can('permission-create')

## Impedindo ao acesso aos botões Edit e Delete
```php
            @can('role-edit')
                <a class="btn btn-primary" href="{{ route('roles.edit',$role->id) }}">Edit</a>
            @endcan
            @can('role-delete')
                {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) !!}
                    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                {!! Form::close() !!}
            @endcan
```
Obs.: para que as tags @can funcionem precisamos antes implementar ACL na aplicação. Um bom exemplo é o pacote spatie.

        @endcan
