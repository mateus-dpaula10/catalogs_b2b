@extends('main')

@section('title', 'Produtos')

@section('content')
    <div id="products_index">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-3">Seus produtos</h4>

                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4">
                    @foreach ($products as $product)
                        <div class="col products mt-2">
                            <div class="card">
                                <div class="card-header p-0">
                                    @foreach($product->images as $image)
                                        @if($image->is_main)
                                            <img src="{{ asset('storage/' . $image->path) }}" alt="Imagem do produto '{{ $product->name }}'">
                                            @break
                                        @endif
                                    @endforeach
                                </div>
                                <div class="card-body">
                                    <h5>{{ $product->name }}</h5>
                                    <p>{!! $product->description !!}</p>
                                    <p>Marca: {{ $product->brand->name }} / <br> Categoria: {{ $product->category->name }}</p>
                                    <button class="btn btn-primary addCart">Preço: R$ {{ number_format($product->price, 2, ',', '.') }}</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                <h4 class="mb-3">Cadastre seu produto</h4>
                <p>
                    Se você tem produtos incríveis e quer alcançar mais clientes, estamos aqui 
                    para ajudar! Nosso catálogo é o lugar perfeito para divulgar seus itens, 
                    aumentar sua visibilidade e expandir seu negócio. Ao cadastrar seus produtos, 
                    você terá acesso a uma plataforma que facilita a exposição e atrai consumidores 
                    de diversas partes.</p>
                <a href="{{ route('product.create', $user) }}"><i class="bi bi-plus-square me-2"></i>Cadastrar produto</a>
            </div>
        </div>
    </div>
@endsection