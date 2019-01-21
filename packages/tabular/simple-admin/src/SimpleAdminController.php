<?php

namespace Tabular\SimpleAdmin;

use App\Http\Controllers\Controller;
use App\User;

use Illuminate\Http\Request;

class SimpleAdminController extends Controller
{
   public function index()
    {
       $users = User::all();
       return view('simpleAdmin::admin')->with('users', $users);
    }
}
