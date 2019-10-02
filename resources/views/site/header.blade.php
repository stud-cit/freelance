@section('header')
    <div class="container-fluid bg-blue mb-5">
        <div class="row py-2 text-white text-center">
                <div class="col-1">
                    <div class="bg-success rounded-circle float-right logo-circle pt-1 font-weight-bold" style="font-family: Arial; letter-spacing: -4px"><span>W</span><span class="font-italic">D</span></div>
                </div>
                <div class="col-1 mt-1">
                    <a href="/" class="text-white">WorkDump</a>
                </div>
                @if(Auth::check())
                    <div class="col-lg-1 col-2 offset-lg-5 offset-1 mt-1 small">
{{--                        <a href="{{ route('customers') }}" class="text-white">Замовники</a>--}}
                    </div>
                    <div class="col-lg-1 col-2 mt-1 small">
                        <a href="{{ route('orders') }}" class="text-white">Проекти</a>
                    </div>
                    <div class="col-lg-1 col-2 mt-1 small">
                        <a href="{{ route('workers') }}" class="text-white">Виконавці</a>
                    </div>
                    <div class="dropdown show col-lg-1 col-2">
                        <button class="dropdown-toggle btn badge-pill border border-light py-1 px-3 text-white small" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="{{Auth::user()->getAvatarPath()}}" title="title" alt="img" class="avatar square-1rem">
                        </button>

                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="{{ route('profile') }}">Профіль</a>
                            @if(Auth::user()->id_role == 2)
                                <a class="dropdown-item" href="{{ route('profile', 'orders') }}">Мої замовлення</a>
                            @endif
                            <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">
                                Вихід
                            </a>
                            <form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
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
{{--                    UA--}}
                </div>
        </div>
    </div>
@endsection
