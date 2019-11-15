@section('header')
    <div class="container-fluid mb-5">
        <div class="d-flex flex-row justify-content-around align-items-center mt-4 text-white text-center"><!--
                <div class="col-1">
                    <div class="bg-success rounded-circle float-right logo-circle pt-1 font-weight-bold" style="font-family: Arial; letter-spacing: -4px"><span>W</span><span class="font-italic">D</span></div>
                </div>-->
                <div class="">
                    <a href="/" class=""><img src="{{ asset('/SVG_logo.svg') }}" alt="WorkDump" height="40px" id="logo"></a>
                </div>
                @if(Auth::check())
                    <div class="col-6 d-flex flex-row justify-content-around">
                        <div class="small">
                            <a href="{{ route('orders') }}" class="text-white">Проекти</a>
                        </div>
                        <div class="small">
                            <a href="{{ route('orders') }}" class="text-white">Туторіал</a>
                        </div>
                        <div class="small">
                            <a href="{{ route('profile') }}" class="text-white">Профіль</a>
                        </div>
                        <div class="small">
                            <a href="{{ route('workers') }}" class="text-white">Виконавці</a>
                        </div>
                        <div class="small">
                            <a href="{{ route('orders') }}" class="text-white">Зв'язок</a>
                        </div>
                    </div>
                    <div class="">

                            @if(Auth::user()->id_role == 2)
                            @endif
                            <a class="badge-pill border border-light py-1 px-4 text-white small" href="#" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">
                                Вихід
                            </a>
                            <form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>

                    </div>
                @else
                    @if(strpos(url()->current(), 'orders') === false && !Auth::check())
                        <div class="small">
{{--                            <a href="{{ route('register') }}" class="text-white">Реєстрація</a>--}}
                            <a href="{{ route('orders') }}" class="text-white">Проекти</a>
                        </div>
                    @else
                        <div class="small"></div>
                    @endif
                    @if(strpos(url()->current(), 'login') === false && !Auth::check())
                        <div class="">
                            <a href="{{ route('login') }}" class="badge-pill bg-orange py-1 px-4 text-white small">Вхід</a>
                        </div>
                    @elseif(strpos(url()->current(), 'login') === false)
                        <div class="">
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();" class="badge-pill border border-light py-1 px-3 text-white small">
                                Вихід
                            </a>
                            <form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    @else
                        <div class=""></div>
                    @endif
                @endif<!--
                <div class="col-1 mt-1">
{{--                    UA--}}
                </div>-->
        </div>
    </div>
@endsection
