# Algumas anotações importantes

Para implementar o código default do laravel para suportar ACL devemos alterar a migration users, adicionando o campo string('role');

Que conterá as roles: admin, autor, comun, etc

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

Portanto, nossa tarefa, na realidade, será permitir que os usuários visualizem os dados dos autores, mas não façam nada com eles - portanto, criar / armazenar / editar / atualizar / excluir deve ser proibido deles.

Polícy é uma classe responsável pelas regras de autorização de um modelo específico - no nosso caso, o model Author.

php artisan make:policy AuthorPolicy --model=Author

You can understand all the purpose of the methods by reading the comments in docblocks. Basically, here you can write the rules for each action, let’s do exactly that.
```php
    public function create(User $user)
    {
        return $user->role == 'admin';
    }

    public function update(User $user, Author $author)
    {
        return $user->role == 'admin';
    }

    public function delete(User $user, Author $author)
    {
        return $user->role == 'admin';
    }
```

Toda função deve retornar true (ação permitida) ou false (ação proibida) com base no objeto $user, que representa automaticamente o usuário conectado. No nosso caso - para todos os métodos, apenas verificamos se um usuário é um admin.

Também removi o método view() da política gerada - não o usamos no nosso caso. Você também pode remover os parâmetros Author $author dos métodos, para que não filtremos os autores por seus objetos, mas, em teoria, você pode fazer isso mesmo.


Registrar a policy e anexar ao model - app/Providers/AuthServiceProvider.php
```php
 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
```
All we need to do is to add our policy and model into $policies array, like this:
```php
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        'App\Author' => 'App\Policies\AuthorPolicy',
    ];
```
Agora podemos usar nossa políticapolicy para verificar se um usuário pode acessar uma ou outra ação. Podemos verificar isso em vários estágios do aplicativo, mas o que eu prefiro fazer em duas etapas: verificar nos Controladores e nas views.
```php
app/Http/Controllers/AuthorsController.php:
    public function create()
    {
        $this->authorize('create', Author::class);
        return view('authors.create');
    }
```
Sim, é simples assim. O método $this->authorize() verifica se o usuário conectado tem permissão para o método [parâmetro 1] no modelo [parâmetro 2].
Agora, se estivermos logado como usuário com role = 'user' (não 'admin'), clicaremos no link para Adicionar novo autor e veremos:

Receberemos um erro
```php
    public function create()
    {
        $this->authorize('create', Author::class);
        return view('authors.create');
    }

    public function store(StoreAuthorRequest $request)
    {
        $this->authorize('create', Author::class);
        Author::create($request->all());
        return redirect()->route('authors.index')->with(['message' => 'Author added successfully']);
    }

    public function edit($id)
    {
        $this->authorize('update', Author::class);
        $author = Author::findOrFail($id);
        return view('authors.edit', compact('author'));
    }

    public function update(StoreAuthorRequest $request, $id)
    {
        $this->authorize('update', Author::class);
        $author = Author::findOrFail($id);
        $author->update($request->all());
        return redirect()->route('authors.index')->with(['message' => 'Author updated successfully']);
    }

    public function destroy($id)
    {
        $this->authorize('delete', Author::class);
        $author = Author::findOrFail($id);
        $author->delete();
        return redirect()->route('authors.index')->with(['message' => 'Author deleted successfully']);
    }

    public function massDestroy(Request $request)
    {
        $this->authorize('delete', Author::class);
        $authors = explode(',', $request->input('ids'));
        foreach ($authors as $author_id) {
            $author = Author::findOrFail($author_id);
            $author->delete();
        }
        return redirect()->route('authors.index')->with(['message' => 'Authors deleted successfully']);
    }
```
Como você pode ver, eu uso a mesma permissão de criação para verificar os métodos create() e store(), porque eles representam a mesma ação - criação da entrada.

But that’s not all. We also need to hide the links and the buttons from non-admin users, so they wouldn’t even see that opportunity. But please make sure that you always make security check from both front-end and back-end – only then you can feel safe.
So, in Blade templates we can use simple function/command called @can. It’s basically a block, like @if – @endif or @foreach – @endforeach, but with a different purpose – to check whether logged-in user actually can view that piece of the view. It looks like this:
```php
resources/views/authors/index.php
    @can('create', Author::class)
        <a href="{{ route('authors.create') }}" class="btn btn-default">Add New Author</a>
        <br /><br />
    @endcan
    <table class="table table-bordered">
        <thead>
            <tr>
                @can('delete', Author::class)
                <th>
                    <input type="checkbox" class="checkbox_all">
                </th>
                @endcan
                <th>First name</th>
                <th>Last name</th>
                @can('edit', Author::class)
                <th>Actions</th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @forelse($authors as $author)
            <tr>
                @can('delete', Author::class)
                <td><input type="checkbox" class="checkbox_delete"
                           name="entries_to_delete[]" value="{{ $author->id }}" /></td>
                @endcan
                <td>{{ $author->first_name }}</td>
                <td>{{ $author->last_name }}</td>
                @can('edit', Author::class)
                <td>
                    <a href="{{ route('authors.edit', $author->id) }}" class="btn btn-default">Edit</a>
                    @can('delete', Author::class)
                    <form action="{{ route('authors.destroy', $author->id) }}" method="POST"
                          style="display: inline"
                          onsubmit="return confirm('Are you sure?');">
                        <input type="hidden" name="_method" value="DELETE">
                        {{ csrf_field() }}
                        <button class="btn btn-danger">Delete</button>
                    </form>
                    @endcan
                </td>
                @endcan
            </tr>
            @empty
                <tr>
                    <td colspan="4">No entries found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    @can('delete', Author::class)
    <form action="{{ route('authors.mass_destroy') }}" method="post"
          onsubmit="return confirm('Are you sure?');">
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="ids" id="ids" value="" />
        <input type="submit" value="Delete selected" class="btn btn-danger" />
    </form>
    @endcan
```
Quite a long piece of code, but you should understand it easily. @can – @endcan blocks accept identically the same parameters as $this->authorize method in controllers.

Se estivermos logados como um simples user não poderemos ver nenhhum botão.

Tutorial
https://quickadminpanel.com/blog/course-lesson-7-roles-permissions-and-authorization/

Fonte
https://quickadminpanel.com/blog/wp-content/uploads/2017/03/laravel-admin.zip

