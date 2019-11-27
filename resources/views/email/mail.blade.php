<link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('css/site.css') }}" rel="stylesheet" type="text/css">

<div class="container text-white">
    <div class="d-flex flex-row">
        <a href="/" class="m-auto"><img src="{{ asset('/SVG_Logo.svg') }}" alt="WorkDump" height="40px" id="logo"></a>
    </div>
    <div class="d-flex flex-column mt-4"><p>Шановний(а) @if(!empty($name)) {{ $name }} @else Іван Іванов@endif.</p>
        <p>@if(!empty($text)) {{ $text }}  @else Шаблонный текст @endif</p>
        <p>Дякуємо за співпрацю з нами.</p>
        <p>Команда WorkDump</p>
    </div>
</div>
<div class="container-fluid bg-light-black text-center text-white">
    <div>WorkDump(c) 2019</div>
</div>
