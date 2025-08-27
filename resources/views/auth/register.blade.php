@extends('auth.main')

@section('title', 'Registrar')

@section ('content')
    @if(session('success'))
        <p class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>                    
        </p>
    @endif

    @if(session('error'))
        <p class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>                    
        </p>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>                    
        </div>
    @endif

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

        <div class="form-group mt-2">        
            <label class="form-label" for="company_name">Nome da loja</label>            
            <input type="text" class="form-control" name="company_name" placeholder="Nome da loja" required>                    
        </div>

        <div class="form-group mt-2">        
            <label class="form-label" for="phone_number">WhatsApp</label>            
            <input type="text" class="form-control" name="phone_number" id="phone_number" placeholder="( ) _____-____" required>                    
        </div>

        <div class="form-group mt-2" id="type">        
            <label class="form-label">Como deseja usar sua página?</label>            
            <div>
                <div id="catalog" class="option_type">
                    <div class="bg">
                        <img src="{{ asset('img/catalog.png') }}" alt="Imagem de catálogo">
                    </div>
                    <small>Catálogo</small>
                </div>
                {{-- <div id="store" class="option_type">
                    <div class="bg">
                        <img src="{{ asset('img/catalog.png') }}" alt="Imagem de catálogo">
                    </div>
                    <small>Loja virtual</small>
                </div>
                <div id="budge" class="option_type">
                    <div class="bg">
                        <img src="{{ asset('img/catalog.png') }}" alt="Imagem de catálogo">
                    </div>
                    <small>Orçamento</small>
                </div> --}}
            </div>
            <input type="hidden" name="type" value="" required>
        </div>

        <div class="form-group mt-3">
            <button type="submit" class="btn btn-outline-primary w-100">Criar conta gratuita</button>
        </div>

        <hr class="mt-4">

        <div class="form-group">
            <p class="mb-0">Já tem cadastro? <a href="{{ route('login') }}">Fazer login</a></p>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const options = document.querySelectorAll('.option_type');
            const wpp = document.getElementById('phone_number');

            options.forEach(option => {
                option.addEventListener('click', function () {
                    options.forEach(o => o.classList.remove('active'));
                    option.classList.add('active');
                    const value = option.getAttribute('id');
                    document.querySelector('input[name="type"]').value = value;
                });
            });

            document.querySelector('form').addEventListener('submit', function (e) {
                const typeValue = document.querySelector('input[name="type"]').value;
                
                if (!typeValue) {
                    e.preventDefault();
                    alert('Selecione como deseja usar a página!');
                }
            });

            wpp.addEventListener('input', function (e) {
                let value = e.target.value.replace(/\D/g, '');
                
                if (value.length > 11) {
                    value = value.slice(0, 11);
                }

                if (value.length <= 10) {
                    value = value.replace(/(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
                } else {
                    value = value.replace(/(\d{2})(\d{5})(\d{0,4})/, '($1) $2-$3');
                }

                e.target.value = value.trim();
            });

            wpp.addEventListener('blur', function (e) {
                const cleanNumber = e.target.value.replace(/\D/g, '');
                e.target.value = cleanNumber;
            });
        });
    </script>
@endpush