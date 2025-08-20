@extends('auth.main')

@section('title', 'Loja')

@section ('content')
    <h4>Quase tudo pronto!</h4>
    <p>Apenas informe os dados da sua loja.</p>

    <form action="{{ route('company.store') }}" method="POST">
        @csrf

        <div class="form-group mt-2">        
            <label class="form-label" for="name">Administrador da loja</label>            
            <input type="text" class="form-control" value="{{ $user->name }}" readonly>                    
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
                <div id="store" class="option_type">
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
                </div>
            </div>
            <input type="hidden" name="type" value="" required>
        </div>

        <div class="form-group mt-3">
            <button type="submit" class="btn btn-outline-primary w-100">Começar a usar</button>
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