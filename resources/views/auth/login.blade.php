@extends('layouts.site')

@section('header')
    @include('site.header')
@endsection

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-5 container">
                <div class="row">
                    <div class="col-12 font-weight-bold text">Авторизація</div>
                </div>
                <div class="row">
                    <div class="col-10 offset-1 font-italic small">Почніть співробітництво</div>
                </div>
                <div>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <ul class="list-group">
                            <!--
                            <li class="list-group-item d-flex flex-row">
                                <div class="">&nbsp;</div>
                                <div class="d-flex flex-column">
                                    <label for="name" class="col-form-label">Ім'я</label>
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror border-0" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Ім'я">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                    @enderror
                                </div>
                                <div class="">&nbsp;</div>
                            </li>
                            -->
                            <li class="list-group-item d-flex flex-row">
                                <div class="">&nbsp;</div>
                                <div class="d-flex flex-column">
                                    <label for="name" class="col-form-label">Електронна адреса</label>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror border-0" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="email">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                    @enderror
                                </div>
                                <div class="">&nbsp;</div>
                            </li>

                            <li class="list-group-item d-flex flex-row">
                                <div class="">&nbsp;</div>
                                <div class="d-flex flex-column">
                                    <label for="name" class="col-form-label">Пароль</label>

                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror border-0" name="password" required autocomplete="new-password" placeholder="********">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="">&nbsp;</div>
                            </li>
                            <!--
                            <li class="list-group-item d-flex flex-row">
                                <div class="">&nbsp;</div>
                                <div class="d-flex flex-column">
                                    <label for="name" class="col-form-label">Повторіть пароль</label>

                                    <input id="password-confirm" type="password" class="form-control border-0" name="password_confirmation" required autocomplete="new-password" placeholder="********">
                                </div>
                                <div class="">&nbsp;</div>
                            </li>
                            -->
                        </ul>

                        <div class="row mt-4">
                            <div class="col-lg-4 col-12 offset-1 custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="rememberme">
                                <label for="rememberme" class="custom-control-label">Запам'ятати</label>
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
                            <div class="col-lg-5 col-12">
                                <button type="submit" class="btn text-white badge-pill w-100 bg-violet">
                                    Вхід
                                </button>
                            </div>

                            <div class="col-lg-5 col-12">
                                <a href="{{ route('register') }}" class="btn btn-outline-secondary badge-pill w-100 bg-white">
                                    Реєстрація
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-6 offset-1">
                <img src="{{ asset('login.jpg') }}" class="img-fluid">
            </div>
        </div>
    </div>
@endsection

@section('header')
    @include('site.footer')
@endsection
