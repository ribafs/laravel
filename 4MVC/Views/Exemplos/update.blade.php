== Routes

        Route::get('/clientes/{id}/edit',['middleware'=>'check-permission:user|admin|super','uses'=>'ClientesController@edit']);
        Route::put('/clientes/{id}/update',['middleware'=>'check-permission:user|admin|super','uses'=>'ClientesController@update']);


== Ajustar método update()

    public function update(Request $request, $id)
    {
        
        $data = $request->all();
        
        $cliente = Cliente::findOrFail($id);
        $cliente->update($data);

        return redirect('clientes.index')->with('flash_message', 'Cliente updated!');
    }

== Action da View edit.blade.php

                        <form method="POST" action="{{ url('/clientes/' . $cliente->id.'/update') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                            {{ method_field('PUT') }}
                            {{ csrf_field() }}

                            @include ('clientes.form', ['formMode' => 'edit'])

                        </form>

