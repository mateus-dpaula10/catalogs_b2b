<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Catálogos b2b</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ==" crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/login/style.css') }}">
</head>
<body>
    <div id="block">
        <div>
            <img src="{{ asset('img/auth/bg.png') }}" alt="Bg tela de login">
        </div>

        <div>
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

            <h4>Login</h4>

            <form action="{{ route('auth.store') }}" method="POST">
                @csrf

                <div class="form-group mt-4">                    
                    <input type="text" class="form-control" placeholder="E-mail" name="email">                    
                </div>
                
                <div class="form-group mt-2">
                    <div class="position-relative">
                        <input type="password" class="form-control" placeholder="********" name="password" id="password">
                        <i class="bi bi-eye-fill" id="btnPassLogin" title="Mostrar senha"></i>
                    </div>
                </div>
    
                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-outline-primary w-100">Entrar</button>
                </div>
            </form>
        </div>
    </div>
    
    <script src="{{ asset('js/login/script.js') }}"></script>
    <script 
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" 
        crossorigin="anonymous">
    </script>
    {{-- <script 
        src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/js/all.min.js" 
        integrity="sha512-gBYquPLlR76UWqCwD06/xwal4so02RjIR0oyG1TIhSGwmBTRrIkQbaPehPF8iwuY9jFikDHMGEelt0DtY7jtvQ==" 
        crossorigin="anonymous" 
        referrerpolicy="no-referrer">
    </script> --}}
</body>
</html>