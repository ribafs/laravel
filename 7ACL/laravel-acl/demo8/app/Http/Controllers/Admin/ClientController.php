<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');        
    }

    public function index(Request $request)
    {
        $auth = Auth::user()->hasRole('super', 'manager', 'user');
        if((!$auth)){
            return view('home');
        }else{
            $keyword = $request->get('search');
            $perPage = 5;

            if (!empty($keyword)) {
                $clients = Client::where('name', 'LIKE', "%$keyword%")
                ->orWhere('email', 'LIKE', "%$keyword%")
                ->orderBy('id')
                ->latest()
                ->paginate($perPage);
            } else {
                $clients = Client::orderBy('id')->latest()->paginate($perPage);
            }

            return view('admin.clients.index', compact('clients'));
        }
    }

    public function create(Request $request)
    {
        if ($request->user()->can('all-no')) {
            return view('admin.clients.create');
        }else{
            print '<a href="#" onClick="window.history.back();">Back to app</a>';
            return '<h3 align="center">Access denied in this demo</h3>';
        }
    }

    public function store(Request $request)
    {
        if ($request->user()->can('all-no')) {            
            $requestData = $request->all();
            
            Client::create($requestData);

            return redirect('admin/clients')->with('flash_message', 'Client added!');
        }else{
            print '<a href="#" onClick="window.history.back();">Back to app</a>';
            return '<h3 align="center">Access denied in this demo</h3>';
        }
    }

    public function show(Request $request,$id)
    {
        if ($request->user()->can('all-no')) {      
            $client = Client::findOrFail($id);

            return view('admin.clients.show', compact('client'));
        }else{
            print '<a href="#" onClick="window.history.back();">Back to app</a>';
            return '<h3 align="center">Access denied in this demo</h3>';
        }
    }

    public function edit(Request $request,$id)
    {
        if ($request->user()->can('all-no')) {    
            $client = Client::findOrFail($id);

            return view('admin.clients.edit', compact('client'));
        }else{
            print '<a href="#" onClick="window.history.back();">Back to app</a>';
            return '<h3 align="center">Access denied in this demo</h3>';
        }
    }

    public function update(Request $request, $id)
    {
        if ($request->user()->can('all-no')) {                
            $requestData = $request->all();
            
            $client = Client::findOrFail($id);
            $client->update($requestData);

            return redirect('admin/clients')->with('flash_message', 'Client updated!');
        }else{
            print '<a href="#" onClick="window.history.back();">Back to app</a>';
            return '<h3 align="center">Access denied in this demo</h3>';
        }
    }

    public function destroy(Request $request,$id)
    {
        if ($request->user()->can('all-no')) {  
            Client::destroy($id);

            return redirect('admin/clients')->with('flash_message', 'Client deleted!');
        }else{
            print '<a href="#" onClick="window.history.back();">Back to app</a>';
            return '<h3 align="center">Access denied in this demo</h3>';
        }
    }
}
