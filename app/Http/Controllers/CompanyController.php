<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CompanyController extends Controller
{
    public function index(User $user)
    {
        return view ('auth.company', compact('user'));
    }

    public function store(Request $request)
    {
        $user = Auth::user(); 

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

        $company = Company::create([
            'name'         => $data['company_name'],
            'phone_number' => $data['phone_number'],
            'type'         => $data['type']
        ]);
        
           
        $user->company()->associate($company)->save();

        return redirect()->route('dashboard.index', $user)->with('success', 'Empresa criada e vinculada ao seu usuário');
    }

    public function consultar($cnpj)
    {
        $cnpj = preg_replace('/\D/', '', $cnpj);

        if (strlen($cnpj) !== 14) {
            return response()->json(['error' => 'CNPJ inválido'], 400);
        }

        $response = Http::get("https://www.receitaws.com.br/v1/cnpj/{$cnpj}");

        if ($response->failed()) {
            return response()->json(['error' => 'Erro ao consultar CNPJ'], 500);
        }

        $data = $response->json();

        if (isset($data['status']) && $data['status'] === 'ERROR') {
            return response()->json(['error' => $data['message']], 400);
        }

        return response()->json($data);
    }
}
