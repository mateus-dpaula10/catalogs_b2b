<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CompanyController extends Controller
{
    public function index()
    {
        return view ('company.index');
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
