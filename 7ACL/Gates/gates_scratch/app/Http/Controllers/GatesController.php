<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class GatesController extends Controller
{
  public function delete()
  {
      if (Gate::allows('isAdmin')) {
          dd('Admin allowed');
      } else {
          dd('You are not Admin');
      }
  }
}
