@extends('main')

@section('title', 'Company')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h4 class="mb-5">Cadastrar empresas</h4>
                
                <form action="">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Digite o CNPJ" name="cnpj" id="cnpj">
                    </div>
                    <div class="form-group mt-2">
                        <input type="text" class="form-control" placeholder="Razão social" name="razao_social" id="razao_social">
                    </div>
                    <div class="form-group mt-2">
                        <input type="text" class="form-control" placeholder="Logradouro" name="logradouro" id="logradouro">
                    </div>
                    <div class="form-group mt-2">
                        <input type="text" class="form-control" placeholder="Bairro" name="bairro" id="bairro">
                    </div>
                    <div class="form-group mt-2">
                        <input type="text" class="form-control" placeholder="Cidade" name="cidade" id="cidade">
                    </div>
                    <div class="form-group mt-2">
                        <input type="text" class="form-control" placeholder="UF" name="uf" id="uf">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('cnpj').addEventListener('blur', async function () {
            let cnpj = this.value.replace(/\D/g, '');

            if (cnpj.length !== 14) {
                alert("CNPJ inválido!");
                return;
            }

            try {
                const response = await fetch(`/consulta-cnpj/${cnpj}`);
                const data = await response.json();

                if (data.error) {
                    alert(data.error);
                    return;
                }

                document.getElementById('razao_social').value = data.nome;
                document.getElementById('logradouro').value = data.logradouro;
                document.getElementById('bairro').value = data.bairro;
                document.getElementById('cidade').value = data.municipio;
                document.getElementById('uf').value = data.uf;
            } catch (err) {
                alert("Erro ao buscar dados do CNPJ.");
                console.error(err);
            }
        });
    </script>
@endpush