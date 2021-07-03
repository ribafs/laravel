<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
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
                $users = User::where('name', 'LIKE', "%$keyword%")
                ->orWhere('email', 'LIKE', "%$keyword%")
                ->orderBy('id')
                ->latest()
                ->paginate($perPage);
            } else {
                $users = User::orderBy('id')->latest()->paginate($perPage);
            }

            return view('admin.users.index', compact('users'));
        }
    }

    public function create(Request $request)
    {
        if ($request->user()->can('all-no')) {
            return view('admin.users.create');
        }else{
            print '<a href="#" onClick="window.history.back();">Back to app</a>';
            return '<h3 align="center">Access denied in this demo</h3>';
        }
    }

    public function store(Request $request)
    {
        if ($request->user()->can('all-no')) {            
            $requestData = $request->all();
            
            User::create($requestData);

            return redirect('admin/users')->with('flash_message', 'User added!');
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
            $user = User::findOrFail($id);

            return view('admin.users.show', compact('user'));
        }
    }

    public function edit(Request $request,$id)
    {
        if ($request->user()->can('all-no')) {
            $user = User::findOrFail($id);

            return view('admin.users.edit', compact('user'));
        }else{
            print '<a href="#" onClick="window.history.back();">Back to app</a>';
            return '<h3 align="center">Access denied in this demo</h3>';
        }
    }

    public function update(Request $request, $id)
    {
        if ($request->user()->can('all-no')) {            
            $requestData = $request->all();
            
            $user = User::findOrFail($id);
            $user->update($requestData);

            return redirect('admin/users')->with('flash_message', 'User updated!');
        }else{
            print '<a href="#" onClick="window.history.back();">Back to app</a>';
            return '<h3 align="center">Access denied in this demo</h3>';
        }
    }

    public function destroy(Request $request,$id)
    {
        if ($request->user()->can('all-no')) {
            User::destroy($id);

            return redirect('admin/users')->with('flash_message', 'User deleted!');
        }else{
            print '<a href="#" onClick="window.history.back();">Back to app</a>';
            return '<h3 align="center">Access denied in this demo</h3>';
        }
    }
}
