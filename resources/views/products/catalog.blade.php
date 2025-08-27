@extends('main')

@section('title', 'Produtos')

@section('content')
    <div id="products_catalog">        
        <div class="card">
            <div class="card-body">
                <h4 class="mb-3">Produtos de {{ $company->name }}</h4>
        
                <ul class="list-group">
                    @foreach($products as $product)
                        <li class="list-group-item d-flex justify-content-between align-items-center mt-3">
                            <div>
                                @if($product->mainImage)
                                    <img src="{{ asset('storage/'.$product->mainImage->path) }}" alt="{{ $product->name }}" style="width:50px; height:50px; object-fit:cover; margin-right:10px;">
                                @endif
                                <input type="checkbox" class="product-checkbox"
                                    data-name="{{ $product->name }}"
                                    data-price="{{ $product->price }}"
                                    data-category="{{ $product->category->name }}"
                                    data-brand="{{ $product->brand->name }}"
                                    data-image="{{ asset('storage/'.$product->mainImage->path ?? '') }}">
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
                    <form id="whatsapp_form" action="{{ route('whatsapp.send') }}" method="POST">
                        @csrf
                        <input type="hidden" name="products_data" id="products_data">
                        <button type="submit" class="btn btn-success" id="send_whatsapp">
                            Enviar selecionados por WhatsApp
                        </button>
                    </form>
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
            const form = document.getElementById('whatsapp_form');
            const hiddenInput = document.getElementById('products_data');

            checkboxes.forEach((checkbox, index) => {
                checkbox.addEventListener('change', function() {
                    quantities[index].disabled = !this.checked;
                });
            });

            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                let selected = [];
                checkboxes.forEach((checkbox, index) => {
                    if (checkbox.checked) {
                        selected.push({
                            name: checkbox.dataset.name,
                            brand: checkbox.dataset.brand,
                            category: checkbox.dataset.category,
                            price: parseFloat(checkbox.dataset.price),
                            qty: parseInt(quantities[index].value),
                            image: checkbox.dataset.image
                        });
                    }
                });

                if (selected.length === 0) {
                    alert('Selecione pelo menos um produto.');
                    return;
                }

                hiddenInput.value = JSON.stringify(selected);

                form.submit();
            });
        });
    </script>
@endpush