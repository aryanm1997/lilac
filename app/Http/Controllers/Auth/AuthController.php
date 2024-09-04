<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Designation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
   
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard')
                        ->withSuccess('You have Successfully loggedin');
        }
  
        return redirect("login")->withError('Oppes! You have entered invalid credentials');
    }

    public function dashboard()
    {
        if(Auth::check()){
            // Fetch users along with their department and designation details
            $users = User::all();
            $department = Department::all();
            $designation = Designation::all();
            // Pass the $users data to the dashboard view using compact
            return view('dashboard', compact('users','department','designation'));
        }

        // If not authenticated, redirect to login with a message
        return redirect("login")->with('error', 'Oops! You do not have access');
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();
  
        return Redirect('login');
    }

    public function store(Request $request)
    {
        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone_number' => $request->input('phone_number'),
            'password' => Hash::make($request->input('password')),
        ]);
    
        // Redirect to the dashboard with a success message
        return redirect()->route('dashboard')->with('success', 'User created successfully.');
    }
}
