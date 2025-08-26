@extends('main')

@section('title', 'Produtos')

@section('content')
    <div id="products_edit">
        <form action="{{ route('product.update', $product) }}" method="POST" enctype="multipart/form-data">
            @method('PATCH')
            @csrf
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name" class="form-label">Nome</label>
                                <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $product->name) }}" required>
                            </div>
                            <div class="form-group mt-3">
                                <label for="description" class="form-label">Descrição</label>
                                <textarea name="description" id="description" class="form-control" rows="5">{{ old('description', $product->description) }}</textarea>
                            </div>
                            <div class="form-group mt-3">
                                <label for="price" class="form-label">Preço</label>
                                <input type="number" step="0.01" class="form-control" name="price" id="price" value="{{ old('price', $product->price) }}" required>
                            </div>
                        </div>
                    </div>
    
                    <div class="card mt-3">
                        <div class="card-body">
                            <label for="images" class="form-label">Imagens do produto</label> <br>
                            <small>Selecione até 10 imagens.</small> <br>
                            <small>A primeira imagem será a imagem principal.</small> <br>
                            <small>Recomendamos imagens quadradas de 900px por 900px jpg, jpeg, ou png de até 5MB.</small> <br><br>
                            <input type="file" name="images[]" id="images" class="form-input-file" multiple accept="image/*">

                            <div class="mt-3">
                                <label>Imagens atuais:</label>
                                <div id="current_images">
                                    @foreach($product->images as $image)
                                        <div>
                                            <img src="{{ asset('storage/'.$image->path) }}" class="img-thumbnail" width="100" height="100">
                                            <div class="form-check mt-1">
                                                <input type="checkbox" name="delete_images[]" value="{{ $image->id }}" class="form-check-input" id="del_{{ $image->id }}">
                                                <label for="del_{{ $image->id }}" class="form-check-label text-danger small">
                                                    Excluir
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div id="image_preview" class="mt-3"></div>
                        </div>
                    </div>
                </div>
    
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="company_id" class="form-label">
                                    Empresa             
                                </label>
                                
                                <select name="company_id" id="company_id" class="form-select mt-1" required disabled>
                                    @foreach($companies as $company)            
                                        <option value="{{ $company->id }}" {{ $company->id === $user->company_id ? 'selected' : '' }}>{{ $company->name }}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="company_id" value="{{ $user->company_id }}">
                            </div>

                            <div class="form-group mt-3">
                                <label for="category_id" class="form-label">
                                    Categoria                                
                                </label>
    
                                <div class="input-group">
                                    <input type="text" class="form-control" name="new_category" placeholder="Nova categoria">
                                </div>
                                
                                <select name="category_id" id="category_id" class="form-select mt-1">
                                    <option value="">Selecione uma categoria</option>
                                    @foreach($categories as $category)            
                                        <option value="{{ $category->id }}" {{ $product->category_id === $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
    
                            <div class="form-group mt-3">
                                <label for="brand_id" class="form-label">
                                    Marca                                
                                </label>
    
                                <div class="input-group">
                                    <input type="text" class="form-control" name="new_brand" placeholder="Nova marca">
                                </div>
                                
                                <select name="brand_id" id="brand_id" class="form-select mt-1">
                                    <option value="">Selecione uma marca</option>
                                    @foreach($brands as $brand)            
                                        <option value="{{ $brand->id }}" {{ $product->brand_id === $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>            

                <div class="col-12 mt-3">
                    <button type="submit" class="btn btn-primary w-100">Editar produto</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push ('scripts')
    <script>
        document.getElementById('images').addEventListener('change', function (e) {
            const previewContainer = document.getElementById('image_preview');
            previewContainer.innerHTML = '';

            const files = e.target.files;

            if (files.length > 10) {
                alert('Você só pode selecionar até 10 imagens.');
                return;
            }

            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                
                if (!file.type.startsWith('image/')) {
                    alert('Somente arquivos de imagem são permitidos.');
                    continue;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgElement = document.createElement('img');
                    imgElement.src = e.target.result;
                    imgElement.classList.add('img-thumbnail');
                    
                    previewContainer.appendChild(imgElement);
                };
                reader.readAsDataURL(file);
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
            const newCategoryInput = document.querySelector('input[name="new_category"]');
            const categorySelect = document.querySelector('select[name="category_id"]');
            const newBrandInput = document.querySelector('input[name="new_brand"]');
            const brandSelect = document.querySelector('select[name="brand_id"]');

            newCategoryInput.addEventListener('input', function () {
                if (this.value.trim() !== '') {
                    categorySelect.selectedIndex = 0;
                }
            });

            newBrandInput.addEventListener('input', function () {
                if (this.value.trim() !== '') {
                    brandSelect.selectedIndex = 0;
                }
            });
        });
    </script>
@endpush