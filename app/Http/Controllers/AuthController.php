<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view ('login');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $user = Auth::user();

            if ($user->role === 'superadmin' || $user->role === 'admin') {
                return redirect()->route('dashboard.index');
            }

            return redirect()->intended('/'); 
        }

        return back()->withErrors([
            'email' => 'As credenciais estão incorretas.'
        ])->onlyInput('email');
    }

    public function logout()
    {   
        
    }
}
