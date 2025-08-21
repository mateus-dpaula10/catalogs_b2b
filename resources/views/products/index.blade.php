@extends('main')

@section('title', 'Produtos')

@section('content')
    <div id="products_index">
        <form action="" method="POST" enctype="multipart/form-data">
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
                                <textarea name="description" id="description" class="form-control" rows="5" required></textarea>
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
                                <label for="categories" class="form-label">
                                    Categoria                                
                                </label>
    
                                <div class="input-group">
                                    <input type="text" class="form-control" name="category" id="category">
                                    <button type="submit" class="btn btn-primary">Criar</button>
                                </div>
                                
                                <select name="categories" id="categories" class="form-select mt-1" required>
                                    <option value="">Categoria 1</option>
                                    <option value="">Categoria 2</option>
                                </select>
                            </div>
    
                            <div class="form-group mt-3">
                                <label for="brands" class="form-label">
                                    Marca                                
                                </label>
    
                                <div class="input-group">
                                    <input type="text" class="form-control" name="category" id="category">
                                    <button type="submit" class="btn btn-primary">Criar</button>
                                </div>
                                
                                <select name="brands" id="brands" class="form-select mt-1" required>
                                    <option value="">Marca 1</option>
                                    <option value="">Marca 2</option>
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