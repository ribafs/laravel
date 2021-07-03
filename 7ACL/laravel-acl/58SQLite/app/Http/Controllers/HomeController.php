<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home()
    {
        return view('home');
    }

    public function index()
    {
        $super = Auth::user()->hasRole('super');
        $admin = Auth::user()->hasRole('admin');
        $manager = Auth::user()->hasRole('manager');
        $user = Auth::user()->hasRole('user');

        if($super || $admin) {
            return redirect('/admin/users');
        }elseif($manager || $user) {
            return redirect('/admin/clients');
        }else{
            return view('home');
        }
    }
}


