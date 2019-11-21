@extends('layouts.site')

@section('header')
    @include('site.header')
@endsection

@section('content')

    <div class="text-white" id="password_change">
        <p class="col font-size-18 text-center">Відновлення адреси</p>
        <form method="POST" action="{{ route('password.email') }}" class="col-6 offset-3 shadow-lg pass_change">
            @csrf
            <div class="col-12">
                <div class="form-group row">
                    <label for="email" class="col-form-label">Email адреса</label>
                    <input id="email" type="email" class="form-control bg-light-black text-white @error('email') is-invalid @enderror border-0" name="email" placeholder="E-mail" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group row justify-content-center">
                    <button type="submit" class="btn bg-green text-white mb-2 mt-2 badge-pill">
                        Відправити
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('footer')
    @include('site.footer')
@endsection
