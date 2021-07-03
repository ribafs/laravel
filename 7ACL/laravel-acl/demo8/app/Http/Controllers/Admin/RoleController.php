<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');        
    }

    public function index(Request $request)
    {
        $auth = Auth::user()->hasRole('super', 'admin');
        if((!$auth)){
            return view('home');
        }else{
            $keyword = $request->get('search');
            $perPage = 25;

            if (!empty($keyword)) {
                $roles = Role::where('name', 'LIKE', "%$keyword%")
                ->orWhere('slug', 'LIKE', "%$keyword%")
                ->orderBy('id')
                ->latest()
                ->paginate($perPage);
            } else {
                $roles = Role::orderBy('id')->latest()->paginate($perPage);
            }

            return view('admin.roles.index', compact('roles'));
        }
    }

    public function create(Request $request)
    {
        if ($request->user()->can('all-no')) {
            return view('admin.roles.create');
        }else{
            print '<a href="#" onClick="window.history.back();">Back to app</a>';
            return '<h3 align="center">Access denied in this demo</h3>';
        }
    }

    public function store(Request $request)
    {
        if ($request->user()->can('all-no')) {
            $requestData = $request->all();
            
            Role::create($requestData);

            return redirect('admin/roles')->with('flash_message', 'Role added!');
        }else{
            print '<a href="#" onClick="window.history.back();">Back to app</a>';
            return '<h3 align="center">Access denied in this demo</h3>';
        }
    }

    public function show($id)
    {
        $auth = Auth::user()->hasRole('super', 'admin');
        if((!$auth)){
            return view('home');
        }else{
            $role = Role::findOrFail($id);

            return view('admin.roles.show', compact('role'));
        }
    }

    public function edit(Request $request,$id)
    {
        if ($request->user()->can('all-no')) {
            $role = Role::findOrFail($id);

            return view('admin.roles.edit', compact('role'));
        }else{
            print '<a href="#" onClick="window.history.back();">Back to app</a>';
            return '<h3 align="center">Access denied in this demo</h3>';
        }
    }

    public function update(Request $request, $id)
    {
        if ($request->user()->can('all-no')) {            
            $requestData = $request->all();
            
            $role = Role::findOrFail($id);
            $role->update($requestData);

            return redirect('admin/roles')->with('flash_message', 'Role updated!');
        }else{
            print '<a href="#" onClick="window.history.back();">Back to app</a>';
            return '<h3 align="center">Access denied in this demo</h3>';
        }
    }

    public function destroy(Request $request,$id)
    {
        if ($request->user()->can('all-no')) {            
            Role::destroy($id);

            return redirect('admin/roles')->with('flash_message', 'Role deleted!');
        }else{
            print '<a href="#" onClick="window.history.back();">Back to app</a>';
            return '<h3 align="center">Access denied in this demo</h3>';
        }
    }
}
