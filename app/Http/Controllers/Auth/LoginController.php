<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{

    public function __construct() {
        $this->middleware('guest');
    }

    public function index() {
        return view('auth.login');
    }

    public function store(Request $request) {

        //validate
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        //sign in user
        if  ( !auth()->attempt($request->only('email', 'password'), $request->remember) ) {
            return back()->with('status', 'Invalid login details');
        }
        
        //redirect
        return redirect()->route('dashboard');

    }

    public function facebook() {
        return Socialite::driver('facebook')->redirect();
    }

    public function facebookRedirect() {

        $user = Socialite::driver('facebook')->user();

        $user = User::firstOrCreate([
            'email' => $user->email
        ], [
            'name' => $user->name,
            'username' => str_replace(' ', '', $user->name), 
            'password' => Hash::make(Str::random(24))
        ]);

        //sign in user
        Auth::login($user, true);

        //redirect
        return redirect()->route('dashboard');
        
    }
}
