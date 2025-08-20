@extends('auth.main')

@section('title', 'Entrar')

@section ('content')
    <h4 class="mb-3">Entre em sua conta</h4>

    <form action="{{ route('auth.logar') }}" method="POST">
        @csrf

        <div class="form-group mt-2">        
            <label class="form-label" for="email">E-mail</label>            
            <input type="text" class="form-control" name="email">                    
        </div>
        
        <div class="form-group mt-2">
            <label class="form-label" for="password">Senha</label>
            <div class="position-relative">
                <input type="password" class="form-control" name="password" id="password">
                <i class="bi bi-eye-fill" id="btnPassLogin" title="Mostrar senha"></i>
            </div>
        </div>

        <div class="form-group mt-3">
            <button type="submit" class="btn btn-outline-primary w-100">Entrar</button>
        </div>

        <hr class="mt-4">

        <div class="form-group">
            <p class="mb-0">Não tem cadastro? <a href="{{ route('auth.register') }}">Cadastrar</a></p>
        </div>
    </form>
@endsection