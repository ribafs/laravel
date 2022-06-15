<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Funcionario;
use Illuminate\Http\Request;

class FuncionarioController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $funcionarios = Funcionario::where('nome', 'LIKE', "%$keyword%")
                ->orWhere('email', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $funcionarios = Funcionario::latest()->paginate($perPage);
        }

        return view('funcionarios.index', compact('funcionarios'));
    }

    public function create()
    {
        return view('funcionarios.create');
    }

    public function store(Request $request)
    {        
        $requestData = $request->all();        
        Funcionario::create($requestData);

        return redirect('funcionarios')->with('flash_message', 'Funcionario added!');
    }

    public function edit($id)
    {
        $funcionario = Funcionario::findOrFail($id);

        return view('funcionarios.edit', compact('funcionario'));
    }

    public function update(Request $request, $id)
    {
        $requestData = $request->all();
        
        $funcionario = Funcionario::findOrFail($id);
        $funcionario->update($requestData);

        return redirect('funcionarios')->with('flash_message', 'Funcionario updated!');
    }

    public function show($id)
    {
        $funcionario = Funcionario::findOrFail($id);

        return view('funcionarios.show', compact('funcionario'));
    }

    public function destroy($id)
    {
        Funcionario::destroy($id);

        return redirect('funcionarios')->with('flash_message', 'Funcionario deleted!');
    }

}
