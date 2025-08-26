@extends('main')

@section('title', 'Produtos')

@section('content')
    <div id="products_catalog">        
        <div class="card">
            <div class="card-body">
                <h4 class="mb-3">Produtos da {{ $company->name }}</h4>
        
                <ul class="list-group">
                    @foreach($products as $product)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                @if($product->mainImage)
                                    <img src="{{ asset('storage/'.$product->mainImage->path) }}" alt="{{ $product->name }}" style="width:50px; height:50px; object-fit:cover; margin-right:10px;">
                                @endif
                                <input type="checkbox" class="product-checkbox" data-name="{{ $product->name }}" data-price="{{ $product->price }}">
                                <strong>{{ $product->name }}</strong><br>
                                R$ {{ number_format($product->price, 2, ',', '.') }}<br>
                                <small>Marca: {{ $product->brand->name }} / Categoria: {{ $product->category->name }}</small>
                            </div>
                            <div>
                                <input type="number" class="form-control quantity-input" min="1" value="1" style="width: 70px;" disabled>
                            </div>
                        </li>
                    @endforeach
                </ul>
                
                <div class="mt-3">
                    <button type="button" class="btn btn-success" id="send_whatsapp">
                        Enviar selecionados por WhatsApp
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.product-checkbox');
            const quantities = document.querySelectorAll('.quantity-input');
            const button = document.getElementById('send_whatsapp');

            // Ativar input quantidade apenas se checkbox marcado
            checkboxes.forEach((checkbox, index) => {
                checkbox.addEventListener('change', function() {
                    quantities[index].disabled = !this.checked;
                });
            });

            button.addEventListener('click', function() {
                let message = 'Segue a lista de produtos selecionados da nossa loja: ';
                checkboxes.forEach((checkbox, index) => {
                    if (checkbox.checked) {
                        const name = checkbox.dataset.name;
                        const qty = quantities[index].value;
                        message += `\n- ${name} x ${qty}`;
                    }
                });

                if (message === 'Segue a lista de produtos selecionados da nossa loja: ') {
                    alert('Selecione pelo menos um produto.');
                    return;
                }

                const whatsappUrl = `https://wa.me/55{{ $company->phone_number }}?text=` + encodeURIComponent(message);
                window.open(whatsappUrl, '_blank');
            });
        });
    </script>
@endpush