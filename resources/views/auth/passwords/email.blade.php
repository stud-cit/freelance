@extends('layouts.site')

@section('header')
    @include('site.header')
@endsection

@section('content')
<div class="container mt-5">

    <div class="row justify-content-center">
        <div class="col-5">
            <div class="row">
                <div class="col-12 font-weight-bold text">Відновлення адреси</div>
            </div>
            <div>
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <ul class="list-group">
                        <li class="list-group-item d-flex flex-row">
                            <div class="d-flex flex-column w-100">
                                <label for="email" class="col-form-label">Email адреса</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror border-0" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                @enderror
                            </div>
                        </li>


                    </ul>

                    <div class="form-group row mt-2 justify-content-center">
                        <div class="col-5">
                            <button type="submit" class="btn text-white badge-pill w-100" style="background-color: #640CAB">
                                Відправити
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>


<!--
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
-->
@endsection
