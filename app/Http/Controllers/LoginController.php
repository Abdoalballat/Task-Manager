<?php

namespace App\Http\Controllers;

use App\Models\login;
use Illuminate\Auth\Events\Failed;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class LoginController extends Controller
{   


public function index()
{
    $users =login::latest()->paginate(50);
return view('users.users_index',compact('users'));
}
public function create()
{
    return view('users.users_create');
}
public function show($id)
{
    $user=login::with('tasks')->findOrFail($id);
    return view('users.users_show',compact('user'));
}


    public function register(request $request)
    {
        $user =$request->validate([
        'username' =>'required|string',
        'email'    =>'required|string|unique:login,email',
        'password' =>'required|string|confirmed',
        'role'     =>'required|string'
        ]);

        $user = login::create([
            'username'=>$user['username'], 
            'email'=>$user['email'], 
            'password'=>Hash::make($user['password']),
            'role' =>$user['role']
        ]);
        return redirect()->route('users.index')->with('success', 'User created successfully');
        // return response()->json(['success','user has been added']);
        
    }
    public function login(request $request){
        $user =$request->validate([
        'email'   =>'string|required|email',
        'password'=>'string|required',
        ]);
            if (!Auth::attempt($user, $request->boolean('remember'))) {  
            return back()
                ->withErrors(['email' => 'Wrong email or password.'])
                ->onlyInput('email');}

        elseif(Auth::user()->status ==0)
            { 
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return back()->withErrors(['email' => 'Your account has not been activated by the admin yet.']);

            }
        else
            {
                $request->session()->regenerate();
                if(Auth::user()->role ==='admin'){
                return redirect()->route('projects.index')->with('Welcome'.''.Auth::user()->username);
                }
                else{
                return redirect()->route('my_tasks')->with('Welcome'.''.Auth::user()->username);
                    
                }

            }
    }
    public function logout(request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->regenerateToken();
        $request->session()->invalidate();
        return redirect()->route('login')->with('success','Logout successfully');
    }
        public function showLoginForm()
    {
        return view('auth.login');
    }
}