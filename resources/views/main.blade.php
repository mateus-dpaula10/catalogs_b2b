<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Catálogos b2b - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/dashboard/style.css') }}">
</head>
<body>
    <header>
        <img src="{{ asset('img/auth/bg.png') }}" alt="Bg tela de login">
        <div>
            @if(Auth::user())
                <form method="POST" action="{{ route('auth.logout') }}">
                    <h6 class="fs-6">{{ auth()->user()->name }}</h6>
                    @csrf
                    <button type="submit" class="fs-6"><i class="bi bi-box-arrow-in-right me-2"></i>Sair</button>
                </form>        
            @else        
                <a href="{{ route('auth.login') }}" class="fs-6"><i class="bi bi-person me-2"></i>Entrar</a>
            @endif
        </div>
    </header>

    <div class="d-flex" id="block_aside_main">
        @if(Auth::user())
            <aside>
                <ul>
                    <li>
                        <a href="{{ route('product.index', auth()->user()->id) }}"><i class="bi bi-cart me-2"></i>Meus produtos</a>
                    </li>                    
                </ul>
            </aside>
        @endif
    
        <main class="{{ Auth::user() ? '' : 'full' }}">
            @if(Auth::user())
                <button type="button" id="toggle_button">
                    ☰
                </button>
            @endif
    
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
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
                    
                        @yield('content')
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <script src="{{ asset('js/dashboard/script.js') }}"></script>
    <script 
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" 
        crossorigin="anonymous">
    </script>
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    @stack('scripts')
</body>
</html>