<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register()
    {
        return view ('auth.register');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'name'     => 'string|required|max:255',
            'email'    => 'email|required|unique:users,email',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[A-Z]/', 
                'regex:/[a-z]/', 
                'regex:/[0-9]/', 
                'regex:/[@$!%*?&]/'
            ]
        ], [
            'name.required'      => 'O campo nome é obrigatório.',
            'email.email'        => 'O campo e-mail não é válido.',
            'email.required'     => 'O campo e-mail é obrigatório',
            'email.unique'       => 'Este e-mail já está em uso.',
            'password.regex'     => 'A senha deve conter pelo menos uma letra maiúscula, uma minúscula, um número e um caractere especial.',
            'password.min'       => 'A senha deve ter pelo menos 8 caracteres.'
        ]);

        $user = User::create([
            'name'     => $credentials['name'],
            'email'    => $credentials['email'],
            'password' => bcrypt($credentials['password'])
        ]);

        Auth::login($user);
        
        return redirect()->route('auth.company', $user)->with('success', 'Usuário cadastrado com sucesso, crie sua loja.');
    }

    public function login()
    {
        return view ('auth.login');
    }

    public function logar(Request $request) {
        $credentials = $request->validate([
            'email'    => 'email|required',
            'password' => 'string|required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            return redirect()->route('auth.company', $user)->with('success', 'Login realizado com sucesso, crie sua loja.');
        }

        return redirect()->route('auth.login')->with('error', 'E-mail ou senha inválidos.');
    }

    public function logout()
    {   
        
    }
}
