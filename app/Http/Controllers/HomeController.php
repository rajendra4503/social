<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use Carbon;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return view('home');

        if (Auth::check()){
            return view('home');
        }

        return view('welcome');
    }

    public function friends($id){
        $user = User::findOrFail($id);
        return view('app.friends')->with('user', $user);
    }

     public function updateOnline(){
       Auth::user()->updateOnlineStatus();
    }
}
