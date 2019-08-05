@section('header')
    <div class="container-fluid bg-primary">
        <div class="row py-2 text-white text-center">
                <div class="col-1">
                    <div class="bg-success rounded-circle float-right" style="width: 2rem; height: 2rem">&nbsp;</div>
                </div>
                <div class="col-1 mt-1">
                    <a href="" class="text-white">StudRISE</a>
                </div>
                @if(strpos(url()->current(), 'register') === false)
                <div class="col-1 offset-7 mt-1 small">
                    <a href="{{ route('register') }}" class="text-white">Реєстрація</a>
                </div>
                @else
                <div class="col-1 offset-7 mt-1 small"></div>
                @endif
                @if(strpos(url()->current(), 'login') === false)
                <div class="col-1">
                    <a href="{{ route('login') }}" class="badge-pill bg-light py-1 px-3 text-dark small">Вхід</a>
                </div>
                @else
                <div class="col-1"></div>
                @endif
                <div class="col-1 mt-1">
                    UA
                </div>
        </div>
    </div>
@endsection
