@extends('layouts.site')

@section('header')
    @include('site.header')
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-10 offset-1 shadow-lg bg-light-grey p-4">
                <div class="row">
                    <div class="col-6 d-flex border-right border-grey">
                        <div class="d-flex flex-column flex-shrink-1 align-self-center mx-auto text-white col-6">
                            <p>Як зареєструватися?</p>
                            <p>1. <a href="mailto:s.panchenko@ias.sumdu.edu.ua">Зв'язатися</a> з нами</p>
                            <p>2. Дочекатися даних для входу на свою електронну адресу</p>
                            <p>3. Використати дану форму для авторизації</p>
                        </div>
                    </div>
                    <div class="col-6 text-white">
                        <div class="row">
                            <div class="col-12 font-weight-bold font-size-50">Авторизація</div>
                        </div>
                        <div>
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="">&nbsp;</div>
                                <div class="d-flex flex-column">
                                    <label for="name" class="col-form-label">Електронна адреса</label>
                                    <input id="email" type="email" class="form-control bg-deep-dark text-white @error('email') is-invalid @enderror border-0" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="">&nbsp;</div>

                                <div class="">&nbsp;</div>
                                <div class="d-flex flex-column">
                                    <label for="name" class="col-form-label">Пароль</label>

                                    <input id="password" type="password" class="form-control bg-deep-dark text-white @error('password') is-invalid @enderror border-0" name="password" required autocomplete="new-password" placeholder="********">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="">&nbsp;</div>

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
                                    <div class="col-lg-5 col-12">
                                        <button type="submit" class="btn text-white badge-pill w-100 bg-orange">
                                            Вхід
                                        </button>
                                    </div>

                                    <div class="col-lg-5 col-12">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('site.footer')
@endsection
