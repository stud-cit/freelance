@extends('layouts.site')

@section('header')
    @include('site.header')
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-10 offset-1 shadow-lg bg-light-grey p-4 mb-4">
                <div class="row">
                    <div class="col-md-5 d-md-flex border-right border-grey d-none">
                        <div class="d-flex flex-column flex-shrink-1 align-self-center mx-auto text-white col-8">
                            <p>Як зареєструватися?</p>
                            <p>1. <a href="{{ route('register') }}">Залиште заяву</a></p>
                            <p>2. Дочекатися підтверження форми адміністратором</p>
                            <p>3. Використати дану форму для авторизації</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-12 text-white offset-md-1">
                        <div class="row">
                            <div class="col-12 font-weight-bold font-size-35">Авторизація</div>
                        </div>
                        <div>
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div>&nbsp;</div>
                                <div class="d-flex flex-column">
                                    <label for="name" class="col-form-label">Електронна адреса</label>
                                    <input id="email" type="email" class="form-control bg-deep-dark text-white @error('email') is-invalid @enderror border-0" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="email">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div>&nbsp;</div>
                                <div>&nbsp;</div>
                                <div class="d-flex flex-column">
                                    <label for="name" class="col-form-label">Пароль</label>

                                    <input id="password" type="password" class="form-control bg-deep-dark text-white @error('password') is-invalid @enderror border-0" name="password" required autocomplete="new-password" placeholder="********">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div>&nbsp;</div>
                                <div class="row mt-4">
                                    <div class="col-lg-4 col-12 offset-1 custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input pointer" id="rememberme" name="remember">
                                        <label for="rememberme" class="custom-control-label pointer">Запам'ятати</label>
                                    </div>
                                    <div class="col-lg-5 col-12 offset-lg-2">
                                        @if (Route::has('password.request'))
                                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                                Забули пароль?
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row mt-5">
                                        <button type="submit" class="col-lg-5 col-12 btn text-white badge-pill bg-orange">
                                            Вхід
                                        </button>
                                        <a href="" class="col-lg-5 offset-lg-1 col-12 btn text-white badge-pill border-white mt-lg-0 mt-2" onclick="event.preventDefault();$('#cabinet-login').submit();">
                                            <img src="{{ asset('/logotip_cabinet.svg') }}" alt="cabinet.sumdu.edu.ua" height="22px" style="margin-top: -8px">
                                            Вхід Ч/З кабінет
                                        </a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-12 d-md-none d-flex justify-content-center">
                        <a href="{{ route('register') }}">Заява на реєстрацію</a>
                    </div>

                    <form action="{{ route('cabinet-login') }}" method="POST" class="d-none" id="cabinet-login">
                        @csrf
                        <button type="submit">

                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="flash-message fixed-bottom text-center">
            @if($errors->any())
                <p class="alert alert-danger alert-dismissible"> {{ $errors->first() }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
            @endif
    </div>

@endsection

@section('footer')
    @include('site.footer')
@endsection
