# Estruturas de controle na Blade
```php
@for ($i = 0; $i < 10; $i++)
    The current value is {{ $i }}
@endfor

@foreach ($users as $user)
    @if ($user->type == 1)
        @continue
    @endif

    <li>{{ $user->name }}</li>

    @if ($user->number == 5)
        @break
    @endif
@endforeach

@forelse ($users as $user)
    <li>{{ $user->name }}</li>
@empty
    <p>No users</p>
@endforelse

@while (true)
    <p>I'm looping forever.</p>
@endwhile

@if (count($records) === 1)
    I have one record!
@elseif (count($records) > 1)
    I have multiple records!
@else
    I don't have any records!
@endif

@isset($records)
    // $records is defined and is not null...
@endisset

@empty($records)
    // $records is "empty"...
@endempty

@can('update', $post)

@endcan

@role('admin') // @if(Auth::check() && Auth::user()->is('admin'))
    // user is admin
@endrole

@permission('edit.articles') // @if(Auth::check() && Auth::user()->can('edit.articles'))
    // user can edit articles
@endpermission

@allowed('edit', $article) // @if(Auth::check() && Auth::user()->allowed('edit', $article))
    // show edit button
@endallowed

@role('admin|moderator', 'all') // @if(Auth::check() && Auth::user()->is('admin|moderator', 'all'))
    // user is admin and also moderator
@else
    // something else
@endrole

@while (true)
    <p>I'm looping forever.</p>
@endwhile

@foreach ($users as $user)
    @if ($loop->first)
        This is the first iteration.
    @endif

    @if ($loop->last)
        This is the last iteration.
    @endif

    <p>This is user {{ $user->id }}</p>
@endforeach

@php
    //
@endphp

@if ($teste === 123)
  É igual
@else
  É diferente
@endif

@isset($t)
  <p>{{$t}}</p>
@endisset

@empty($t2)
  {{}$t2}
@endempty

@switch($teste)
  @case(1)
    Iguar a 1
    @break
  @case(2)
    Iguar a 2
    @break
  @case(3)
    Iguar a 3
    @break 
  @default
    Default 
@endswitch

@if(isset($testes))
@foreach($testes as $teste)
  <p>{{$teste}}</p>
@endforeach
@endif

@forelse($testes as $teste)
  <p>{{$teste}}</p>
@empty
  <p>Não existem produtos cadastrados</p>
@endforeach


@endsection

Variável que mostra último elemento e muito mais

Criar classe css com nome last e background chamativo

@foreach($testes as $teste)  
  <p class="@if(@loop->last) last @endif">{{$teste}}</p>
@endforeach

@loop->first
```
## Controles no Template
```php
@section('content')

@if ($var1 == '123')

É igual
@endif

@endsection

@for($i;$<10;$i++)

@foreach($posts as $post)

@forelse
```
## Comentários
```php
{{--
comentado

--}}

@php

@endphp
```

## O Blade cria sempre automaticamente para nós uma variável $loop
```php
@foreach ($users as $user)
    @if ($loop->first)
        This is the first iteration.
    @endif

    @if ($loop->last)
        This is the last iteration.
    @endif

    <p>This is user {{ $user->id }}</p>
@endforeach

@foreach ($users as $user)
    @foreach ($user->posts as $post)
        @if ($loop->parent->first)
            This is first iteration of the parent loop.
        @endif
    @endforeach
@endforeach
```
A variável $loop contém uma variedade de propriedades úteis:
```php
Property 	Description
$loop->index 	The index of the current loop iteration (starts at 0).
$loop->iteration 	The current loop iteration (starts at 1).
$loop->remaining 	The iterations remaining in the loop.
$loop->count 	The total number of items in the array being iterated.
$loop->first 	Whether this is the first iteration through the loop.
$loop->last 	Whether this is the last iteration through the loop.
$loop->even 	Whether this is an even iteration through the loop.
$loop->odd 	Whether this is an odd iteration through the loop.
$loop->depth 	The nesting level of the current loop.
$loop->parent 	When in a nested loop, the parent's loop variable.

@foreach ($users as $user)
    @if ($loop->first)
        <p style="color:red">{{$user}}</p>
    @else
        <p>{{$user}}</p>
    @endif
    <p>This is user {{ $user->id }}</p>
@endforeach
```

