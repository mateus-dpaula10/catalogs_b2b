@extends('main')

@section('title', 'Produtos')

@section('content')
    <div id="products_create">
        <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name" class="form-label">Nome</label>
                                <input type="text" class="form-control" name="name" id="name" required>
                            </div>
                            <div class="form-group mt-3">
                                <label for="description" class="form-label">Descrição</label>
                                <textarea name="description" id="description" class="form-control" rows="5"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="price" class="form-label">Preço</label>
                                <input type="number" step="0.01" class="form-control" name="price" id="price" required>
                            </div>
                        </div>
                    </div>
    
                    <div class="card mt-3">
                        <div class="card-body">
                            <label for="images" class="form-label">Imagens do produto</label> <br>
                            <small>Selecione até 10 imagens.</small> <br>
                            <small>A primeira imagem será a imagem principal.</small> <br>
                            <small>Recomendamos imagens quadradas de 900px por 900px jpg, jpeg, ou png de até 5MB.</small> <br><br>
                            <input type="file" name="images[]" id="images" class="form-input-file" multiple required>
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
                                <input type="hidden" name="company_id" value={{ $user->company_id }}>
                            </div>

                            <div class="form-group mt-3">
                                <label for="category_id" class="form-label">
                                    Categoria                                
                                </label>
    
                                <div class="input-group">
                                    <input type="text" class="form-control" name="new_category" placeholder="Nova categoria">
                                    <button type="submit" class="btn btn-primary">Criar</button>
                                </div>
                                
                                <select name="category_id" id="category_id" class="form-select mt-1">
                                    <option value="">Selecione uma categoria</option>
                                    @foreach($categories as $category)            
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
    
                            <div class="form-group mt-3">
                                <label for="brand_id" class="form-label">
                                    Marca                                
                                </label>
    
                                <div class="input-group">
                                    <input type="text" class="form-control" name="new_brand" placeholder="Nova marca">
                                    <button type="submit" class="btn btn-primary">Criar</button>
                                </div>
                                
                                <select name="brand_id" id="brand_id" class="form-select mt-1">
                                    <option value="">Selecione uma marca</option>
                                    @foreach($brands as $brand)            
                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>            

                <div class="col-12 mt-3">
                    <button type="submit" class="btn btn-outline-primary w-100">Cadastrar produto</button>
                </div>
            </div>
        </form>
    </div>
@endsection