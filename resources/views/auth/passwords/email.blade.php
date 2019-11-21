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
                <div class="form-group row">
                    <button type="submit" class="btn bg-green text-white m-4 badge-pill w-100">
                        Відправити
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!--
<div class="container">

    <div class="row justify-content-center">
        <div class="col-5">
            <div class="row">
                <div class="col-12 font-weight-bold text"></div>
            </div>
            <div>
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <ul class="list-group">
                        <li class="list-group-item d-flex flex-row">
                            <div class="d-flex flex-column w-100">
                                <label for="email" class="col-form-label">Email адреса</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror border-0" name="email" placeholder="E-mail" value="{{ old('email') }}" required autocomplete="email" autofocus>
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
    </div>-->
@endsection
