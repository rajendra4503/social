<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Response;
use Image;
use App\User;
use Auth;

class ProfileController extends Controller
{
	public function view($id){
		$user = User::findOrFail($id);
		return view('app.profile')->with('user', $user);
	}
}
