<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
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
            $perPage = 5;

            if (!empty($keyword)) {
                $permissions = Permission::where('name', 'LIKE', "%$keyword%")
                ->orWhere('slug', 'LIKE', "%$keyword%")
                ->orderBy('id')
                ->latest()
                ->paginate($perPage);
            } else {
                $permissions = Permission::orderBy('id')->latest()->paginate($perPage);
            }

            return view('admin.permissions.index', compact('permissions'));
        }
    }

    public function create(Request $request)
    {
        if ($request->user()->can('all-no')) {
            return view('admin.permissions.create');
        }else{
            print '<a href="#" onClick="window.history.back();">Back to app</a>';
            return '<h3 align="center">Access denied in this demo</h3>';
        }
    }

    public function store(Request $request)
    {
        if ($request->user()->can('all-no')) {            
            $requestData = $request->all();
            
            Permission::create($requestData);

            return redirect('admin/permissions')->with('flash_message', 'Permission added!');
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
            $permission = Permission::findOrFail($id);

            return view('admin.permissions.show', compact('permission'));
        }
    }

    public function edit(Request $request,$id)
    {
        if ($request->user()->can('all-no')) {  
            $permission = Permission::findOrFail($id);

            return view('admin.permissions.edit', compact('permission'));
        }else{
            print '<a href="#" onClick="window.history.back();">Back to app</a>';
            return '<h3 align="center">Access denied in this demo</h3>';
        }
    }

    public function update(Request $request, $id)
    {
        if ($request->user()->can('all-no')) {  
            $requestData = $request->all();
            
            $permission = Permission::findOrFail($id);
            $permission->update($requestData);

            return redirect('admin/permissions')->with('flash_message', 'Permission updated!');
        }else{
            print '<a href="#" onClick="window.history.back();">Back to app</a>';
            return '<h3 align="center">Access denied in this demo</h3>';
        }

    }

    public function destroy(Request $request,$id)
    {
        if ($request->user()->can('all-no')) {  
            Permission::destroy($id);

            return redirect('admin/permissions')->with('flash_message', 'Permission deleted!');
        }else{
            print '<a href="#" onClick="window.history.back();">Back to app</a>';
            return '<h3 align="center">Access denied in this demo</h3>';
        }
    }
}
