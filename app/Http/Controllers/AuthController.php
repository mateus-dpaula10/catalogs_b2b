<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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

        if ($user->company_id) {
            return back()->withErrors([
                'company_name' => 'Usuário já possui uma loja cadastrada.'
            ]);
        }

        $data = $request->validate([
            'company_name' => [
                'string',
                'required',
                'max:255',
                'unique:companies,name'
            ],  
            'phone_number' => 'string|required|max:20',
            'type'         => 'string|required|in:catalog,store,budge'
        ], [
            'company_name.required' => 'O nome da loja é obrigatório.',
            'company_name.max'      => 'O nome da loja não pode passar de 255 caracteres.',
            'company_name.unique'   => 'Já existe uma loja cadastrada com este nome.',
            'phone_number.required' => 'O WhatsApp é obrigatório.',
            'type.required'         => 'O tipo do uso da página é obrigatório.',
            'type.in'               => 'Selecione um tipo válido: Catálogo, Loja virtual ou Orçamento.'
        ]);

        $slug = Str::slug($data['company_name']);
        $originalSlug = $slug;
        $counter = 1;

        while (Company::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $company = Company::create([
            'name'         => $data['company_name'],
            'phone_number' => $data['phone_number'],
            'type'         => $data['type'],
            'slug'         => $slug
        ]);

        $user->company()->associate($company)->save();

        return redirect()->route('product.index')->with('success', 'Usuário e empresas criados com sucesso.');
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

            $intended = session('url.intended', route('product.index'));
            return redirect($intended)->with('success', 'Usuário logado com sucesso.');
        }

        return redirect()->route('login')->with('error', 'E-mail ou senha inválidos.');
    }

    public function logout(Request $request)
    {   
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Usuário deslogado com sucesso.');
    }
}
