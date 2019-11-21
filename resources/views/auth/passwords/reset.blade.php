@extends('layouts.site')

@section('header')
    @include('site.header')
@endsection

@section('content')

    <div class="text-white" id="password_change">
        <p class="col font-size-18 text-center">Відновлення паролю</p>
        <form method="POST" action="{{ route('password.update') }}" class="col-6 offset-3 shadow-lg pass_change pt-4 pb-2">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="col-12">
                <div class="form-group row">
                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail:') }}</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control bg-light-black text-white @error('email') is-invalid @enderror border-0" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Пароль:') }}</label>

                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control bg-light-black text-white border-0 @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Підтвердіть пароль:') }}</label>

                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control bg-light-black text-white border-0" name="password_confirmation" required autocomplete="new-password">
                    </div>
                </div>
                <div class="form-group row justify-content-center">
                    <button type="submit" class="btn bg-green badge-pill text-white">
                        {{ __('Підтвердити') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
