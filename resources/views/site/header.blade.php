@section('header')
    <div class="container-fluid bg-blue">
        <div class="row py-2 text-white text-center">
                <div class="col-1">
                    <div class="bg-success rounded-circle float-right logo-circle">&nbsp;</div>
                </div>
                <div class="col-1 mt-1">
                    <a href="/" class="text-white">StudRISE</a>
                </div>
                @if(Auth::check())
                    <div class="col-1 offset-5 mt-1 small">
                        <a href="/orders" class="text-white">Проекти</a>
                    </div>
                    <div class="col-1 mt-1 small">
                        <a href="/customers" class="text-white">Замовники</a>
                    </div>
                    <div class="col-1 mt-1 small">
                        <a href="/workers" class="text-white">Виконавці</a>
                    </div>
                    <div class="col-1">
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();" class="badge-pill border border-light py-1 px-3 text-white small">
                            Вихід
                        </a>
                        <form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </div>
                @else
                    @if(strpos(url()->current(), 'register') === false && !Auth::check())
                    <div class="col-1 offset-7 mt-1 small">
                        <a href="{{ route('register') }}" class="text-white">Реєстрація</a>
                    </div>
                    @else
                    <div class="col-1 offset-7 mt-1 small"></div>
                    @endif
                    @if(strpos(url()->current(), 'login') === false && !Auth::check())
                    <div class="col-1">
                        <a href="{{ route('login') }}" class="badge-pill border border-light py-1 px-3 text-white small">Вхід</a>
                    </div>
                    @elseif(strpos(url()->current(), 'login') === false)
                    <div class="col-1">
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();" class="badge-pill border border-light py-1 px-3 text-white small">
                            Вихід
                        </a>
                        <form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </div>
                    @else
                    <div class="col-1"></div>
                    @endif
                @endif
                <div class="col-1 mt-1">
                    UA
                </div>
        </div>
    </div>
@endsection
