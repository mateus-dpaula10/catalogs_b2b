<h1>Olá {{ $user->name }} - {{ $user->email }}</h1>
<h2>Loja: {{ $user->company->name }}</h2>
<h2>WhatsApp: {{ $user->company->phone_number }}</h2>
@php
    $tipo = match($user->company->type) {
        'catalog' => 'Catálogo',
        'store'   => 'Loja Virtual',
        'budge'   => 'Orçamento',
        default   => ''
    };
@endphp
<h2>Tipo: {{ $tipo }}</h2>