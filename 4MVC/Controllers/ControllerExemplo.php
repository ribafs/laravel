<?php
namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Client;
use Illuminate\Http\Request;
use Session;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 2;

        if (!empty($keyword)) {
            $clients = Client::where('nome', 'LIKE', "%$keyword%")
				->orWhere('email', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $clients = Client::paginate($perPage);
        }

        return view('admin.clients.index', compact('clients'));
    }

    public function create()
    {
        return view('admin.clients.create');
    }

    public function store(Request $request)
    {
        
        $requestData = $request->all();        
        Client::create($requestData);
        Session::flash('flash_message', 'Client added!');
        return redirect('admin/clients');
    }

    public function show($id)
    {
        $client = Client::findOrFail($id);

        return view('admin.clients.show', compact('client'));
    }

    public function edit($id)
    {
        $client = Client::findOrFail($id);

        return view('admin.clients.edit', compact('client'));
    }

    public function update($id, Request $request)
    {
        
        $requestData = $request->all();
        
        $client = Client::findOrFail($id);
        $client->update($requestData);

        Session::flash('flash_message', 'Client updated!');

        return redirect('admin/clients');
    }

    public function destroy($id)
    {
        Client::destroy($id);

        Session::flash('flash_message', 'Client deleted!');

        return redirect('admin/clients');
    }
}
