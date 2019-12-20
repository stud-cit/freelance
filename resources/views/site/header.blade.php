@section('header')
    <div class="container-fluid mb-5">
        <div class="d-flex flex-row justify-content-around align-items-center mt-4 text-white text-center">
            <div>
                <a href="/" class=""><img src="{{ asset('/SVG_Logo.svg') }}" alt="WorkDump" height="40px" id="logo"></a>
            </div>
            @if(Auth::check())
                <div class="col-6 d-flex flex-row justify-content-around" id="routes">
                    <div>
                        <a href="{{ route('orders') }}" class="text-white">Проекти</a>
                    </div>
                    @if(Auth::user()->id_role == 1)
                    <div>
                        <a href="{{ route('admin') }}" class="text-white">Панель адміна</a>
                    </div>
                    @endif
                    @if(Auth::user()->id_role == 2)
                        <div>
                            <a href="{{ route('my_orders') }}" class="text-white">Мої замовлення <span class="badge badge-pill bg-orange @if(Auth::user()->order_change() == 0 )d-none @endif">{{ Auth::user()->order_change() }}</span></a>
                        </div>
                        <div>
                            <a href="{{ route('workers') }}" class="text-white">Виконавці</a>
                        </div>
                    @endif
                    @if(Auth::user()->id_role == 3)
                        <div>
                            <a href="{{ route('my_orders') }}" class="text-white">Мої пропозиції&nbsp;<span class="badge badge-pill bg-orange @if(Auth::user()->new_messages() == 0 )d-none @endif">{{ Auth::user()->order_change() }}</span></a>
                        </div>
                    @endif
                    <div>
                        <a href="{{ route('to_chat') }}" class="text-white">Чат&nbsp;<span class="header-count badge badge-pill bg-orange @if(Auth::user()->new_messages() == 0 )d-none @endif">{{ Auth::user()->new_messages() }}</span></a>
                    </div>
                    <div>
                        <a href="{{ route('user', Auth::id()) }}" class="text-white">Профіль</a>
                    </div>
                </div>
                <div>
                    @if(Auth::user()->id_role == 2)
                    @endif
                    <a class="dropdown-toggle pointer" id="profile_btn" data-toggle="dropdown">
                        @if(Auth::user()->id_role == 1)
                            Адміністратор
                        @endif
                        @if(Auth::user()->id_role == 2)
                            Замовник
                        @endif
                        @if(Auth::user()->id_role == 3)
                            Виконавець
                        @endif
                        &nbsp;<img src="{{Auth::user()->getAvatarPath()}}" title="title" alt="img" class="avatar square-1rem circle">
                    </a>
                    <div class="dropdown-menu bg-deep-dark text-white shadow-lg" aria-labelledby="profile_btn">
                        <div class="dropdown-item text-white">{{ Auth::user()->getName() }}</div>
                        <a class="dropdown-item text-white" href="{{ route('profile') }}">Профіль</a>
                        @if(Auth::user()->id_role == 1)
                            <a class="dropdown-item text-white" href="{{ route('admin') }}">Панель адміністратора</a>
                        @endif
                        @if(Auth::user()->id_role == 2)
                            <a class="dropdown-item text-white" href="{{ route('my_orders') }}">Замовлення</a>
                        @endif
                        @if(Auth::user()->id_role == 3)
                            <a class="dropdown-item text-white" href="{{ route('my_orders') }}">Пропозиції</a>
                        @endif
                        @if(Auth::user()->id_role != 1)
                            <a class="dropdown-item text-white" href="{{ route('settings') }}">Налаштування</a>
                        @endif
                        <a class="dropdown-item text-white" href="#" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">
                            Вихід
                        </a>
                        <form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </div>

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
