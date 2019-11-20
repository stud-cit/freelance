@extends('layouts.site')

@section('header')
    @include('site.header')
@endsection

@section('content')
    <div class="text-white" id="password_change">
        <p class="col font-size-18 text-center">Зміна паролю</p>
        <form method="POST" action="{{ route('change_pass') }}" class="col-6 offset-3 shadow-lg pass_change">
            @csrf
            <div class="col-12">
                <div class="form-group row">
                    <label for="old_password" class="col-5 col-form-label mt-2">Старий пароль:</label>
                    <div class="col-6 mt-2">
                        <input type="password" id="old_password" class="form-control bg-light-black text-white @error('old_password') is-invalid @enderror border-0" name="old_password" required placeholder="********">
                        @error('old_password')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="new_password" class="col-5 col-form-label mt-2">Новий пароль:</label>
                    <div class="col-6 mt-2">
                        <input type="password" id="new_password" class="form-control bg-light-black text-white @error('new_password') is-invalid @enderror border-0" name="new_password" required placeholder="********">
                        @error('new_password')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label for="new_password_confirmation" class="col-5 col-form-label mt-2">Повторіть новий пароль:</label>
                    <div class="col-6 mt-2">
                        <input type="password" id="new_password_confirmation" class="form-control bg-light-black text-white border-0" name="new_password_confirmation" required placeholder="********">
                    </div>
                </div>
                <div class="form-group row">
                    <button type="submit" class="col-3 offset-8 text-white btn badge-pill bg-green mb-2 px-0" name="form_password">Підтвердити</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('footer')
    @include('site.footer')
@endsection
