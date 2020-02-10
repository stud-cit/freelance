@section('header')
    <div class="container-fluid mb-5">
        <div class="d-flex flex-row justify-content-around align-items-center mt-4 text-white text-center">
            <div>
                <a href="/"><img src="{{ asset('/SVG_Logo.svg') }}" alt="WorkDump" height="40px" id="logo"></a>
            </div>
            @if(Auth::check())
                <div class="col-6 d-md-flex d-none flex-row justify-content-around" id="routes">
                    <div>
                        <a href="{{ route('orders') }}" class="text-white">Проєкти</a>
                    </div>
                    @if(Auth::user()->id_role == 1)
                        <div>
                            <a href="{{ route('admin') }}" class="text-white">Панель адміністратора</a>
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
                        <div>
                            <a href="{{ route('customers') }}" class="text-white">Замовники</a>
                        </div>
                    @endif
                    <div>
                        <a href="{{ route('to_chat') }}" class="text-white">Чат&nbsp;<span class="header-count badge badge-pill bg-orange @if(Auth::user()->new_messages() == 0 )d-none @endif">{{ Auth::user()->new_messages() }}</span></a>
                    </div>
                    <div>
                        <a href="{{ route('user', Auth::id()) }}" class="text-white">Профіль</a>
                    </div>
                </div>
                <div class="d-md-flex d-none">
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
                        &nbsp;<img src="{{ Auth::user()->getAvatarPath() }}" title="title" alt="img" class="avatar square-1rem circle">
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
                <div class="d-md-none d-flex">
                    <a class="bg-white text-dark font-size-25 badge-pill btn py-0 px-4" data-toggle="collapse" href="#mobile-bar">&#8801; &#8227;</a>
                </div>
                <div class="position-fixed d-md-none bg-white text-dark collapse" id="mobile-bar" style="z-index: 100; top: 0; right: 0; bottom: 0; left: 0;">
                    <div class="container-fluid mt-4 justify-content-around">
                        <a class="text-dark font-size-25 btn py-0 px-3 offset-6" data-toggle="collapse" href="#mobile-bar">X</a>
                    </div>
                    <div class="col-12 d-flex flex-column justify-content-center font-size-30" id="routes">
                        <div>
                            @if(Auth::user()->id_role == 1)
                                Адміністратор
                            @endif
                            @if(Auth::user()->id_role == 2)
                                Замовник
                            @endif
                            @if(Auth::user()->id_role == 3)
                                Виконавець
                            @endif
                            &nbsp;<img src="{{ Auth::user()->getAvatarPath() }}" title="title" alt="img" class="avatar square-2rem circle">
                        </div>
                        <div>
                            <a href="{{ route('orders') }}" class="text-dark">Проєкти</a>
                        </div>
                        @if(Auth::user()->id_role == 1)
                            <div>
                                <a href="{{ route('admin') }}" class="text-dark">Панель адміністратора</a>
                            </div>
                        @endif
                        @if(Auth::user()->id_role == 2)
                            <div>
                                <a href="{{ route('my_orders') }}" class="text-dark">Мої замовлення <span class="badge badge-pill bg-orange @if(Auth::user()->order_change() == 0 )d-none @endif">{{ Auth::user()->order_change() }}</span></a>
                            </div>
                            <div>
                                <a href="{{ route('workers') }}" class="text-dark">Виконавці</a>
                            </div>
                        @endif
                        @if(Auth::user()->id_role == 3)
                            <div>
                                <a href="{{ route('my_orders') }}" class="text-dark">Мої пропозиції&nbsp;<span class="badge badge-pill bg-orange @if(Auth::user()->new_messages() == 0 )d-none @endif">{{ Auth::user()->order_change() }}</span></a>
                            </div>
                            <div>
                                <a href="{{ route('customers') }}" class="text-dark">Замовники</a>
                            </div>
                        @endif
                        <div>
                            <a href="{{ route('to_chat') }}" class="text-dark">Чат&nbsp;<span class="header-count badge badge-pill bg-orange @if(Auth::user()->new_messages() == 0 )d-none @endif">{{ Auth::user()->new_messages() }}</span></a>
                        </div>
                        <div>
                            <a href="{{ route('user', Auth::id()) }}" class="text-dark">Профіль</a>
                        </div>
                        @if(Auth::user()->id_role != 1)
                            <div>
                                <a href="{{ route('settings') }}" class="text-dark">Налаштування</a>
                            </div>
                        @endif
                        <div>
                            <a class="text-dark" href="#" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">
                                Вихід
                            </a>
                            <form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </div>
                </div>
            @else
                @if(strpos(url()->current(), 'orders') === false || strpos(url()->current(), 'orders/') !== false)
                    <div>
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
