@extends('auth.main')

@section('title', 'Registrar')

@section ('content')
    <h4>Crie sua conta gratuita</h4>
    <p>Não pedimos seu cartão de crédito</p>

    <form action="{{ route('auth.store') }}" method="POST">
        @csrf

        <div class="form-group mt-2">        
            <label class="form-label" for="name">Seu nome</label>            
            <input type="text" class="form-control" name="name" required>                    
        </div>

        <div class="form-group mt-2">        
            <label class="form-label" for="email">E-mail</label>            
            <input type="text" class="form-control" name="email" required>                    
        </div>
        
        <div class="form-group mt-2">
            <label class="form-label" for="password">Senha</label>
            <div class="position-relative">
                <input type="password" class="form-control" name="password" id="password" required>
                <i class="bi bi-eye-fill" id="btnPassLogin" title="Mostrar senha"></i>
            </div>
            <small>A senha deve conter pelo menos uma letra maiúscula, uma minúscula, um número, um caractere especial e pelo menos 8 caracteres.</small>
        </div>

        <div class="form-group mt-3">
            <button type="submit" class="btn btn-outline-primary w-100">Criar conta gratuita</button>
        </div>

        <hr class="mt-4">

        <div class="form-group">
            <p class="mb-0">Já tem cadastro? <a href="{{ route('auth.login') }}">Fazer login</a></p>
        </div>
    </form>
@endsection