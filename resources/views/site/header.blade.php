@section('header')
    <div class="container-fluid mb-5">
        <div class="d-flex flex-row justify-content-around align-items-center mt-4 text-white text-center">
                <div>
                    <a href="/" class=""><img src="{{ asset('/SVG_Logo.svg') }}" alt="WorkDump" height="40px" id="logo"></a>
                </div>
                @if(Auth::check())
                    <div class="col-6 d-flex flex-row justify-content-around">
                        <div>
                            <a href="{{ route('orders') }}" class="text-white">Проекти</a>
                        </div>
                        <div>
                            <a href="{{ route('orders') }}" class="text-white">Туторіал</a>
                        </div>
                        <div>
                            <a href="{{ route('user', Auth::id()) }}" class="text-white">Профіль</a>
                        </div>
                        <div>
                            <a href="{{ route('workers') }}" class="text-white">Виконавці</a>
                        </div>
                        <div>
                            <a href="{{ route('to_chat') }}" class="text-white">Зв'язок</a>
                        </div>
                    </div>
                    <div>

                            @if(Auth::user()->id_role == 2)
                            @endif
                            <a class="badge-pill border border-light py-1 px-4 text-white" href="#" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">
                                Вихід
                            </a>
                            <form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>

                    </div>
                @else
                    @if(strpos(url()->current(), 'orders') === false && !Auth::check())
                        <div>
{{--                            <a href="{{ route('register') }}" class="text-white">Реєстрація</a>--}}
                            <a href="{{ route('orders') }}" class="text-white">Проекти</a>
                        </div>
                    @else
                        <div></div>
                    @endif
                    @if(strpos(url()->current(), 'login') === false && !Auth::check())
                        <div>
                            <a href="{{ route('login') }}" class="badge-pill bg-orange py-1 px-4 text-white">Вхід</a>
                        </div>
                    @elseif(strpos(url()->current(), 'login') === false)
                        <div>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();" class="badge-pill border border-light py-1 px-3 text-white">
                                Вихід
                            </a>
                            <form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    @else
                        <div></div>
                    @endif
                @endif
        </div>
    </div>
@endsection
