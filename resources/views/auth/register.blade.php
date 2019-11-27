@extends('layouts.site')

@section('header')
    @include('site.header')
@endsection

@section('content')


    <div class="text-white" id="password_change">
        <p class="col font-size-18 text-center">Заявка на реєстрацію</p>
        <form method="POST" action="{{ route('send_application') }}" class="col-6 offset-3 shadow-lg pass_change">
            @csrf
            <div class="col-12">
                <div class="form-group row">
                    <label for="name" class="col-form-label">Ім'я</label>
                    <input id="name" type="text" class="form-control bg-light-black text-white border-0" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Ім'я">
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group row">
                    <label for="surname" class="col-form-label">Прізвище</label>
                    <input id="surname" type="text" class="form-control bg-light-black text-white border-0" name="surname" value="{{ old('surname') }}" required autocomplete="surname" autofocus placeholder="Прізвище">
                    @error('surname')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group row">
                    <label for="id_role" class="col-form-label">Роль</label>
                    <select id="id_role" class="form-control bg-light-black text-white border-0" name="id_role">
                        <option {{old('id_role') == 'Виконавець' ? 'selected' : ''}}>Виконавець</option>
                        <option {{old('id_role') == 'Замовник' ? 'selected' : ''}}>Замовник</option>
                    </select>
                </div>
                <div class="form-group row">
                    <label for="name" class="col-form-label">Електронна адреса</label>
                    <input id="email" type="email" class="form-control bg-light-black text-white @error('email') is-invalid @enderror border-0" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="email">
                    @error('email')
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

<!--

<div class="container">
    <div class="row">
        <div class="col-7">
            <img src="{{ asset('registration.jpg') }}" class="img-fluid">
        </div>
        <div class="col-5 container">
            <div class="row">
                <div class="col-12 font-weight-bold text">Реєстрація</div>
            </div>
            <div class="row">
                <div class="col-10 offset-1 font-italic small">Почніть співпрацювати</div>
            </div>
            <div>
                <form method="POST" action="{{ route('send_application') }}">
                        @csrf
                        <ul class="list-group">
                            <li class="list-group-item d-flex flex-row">
                                <div class="">&nbsp;</div>
                                <div class="d-flex flex-column">
                                    <label for="name" class="col-form-label">Ім'я</label>
                                    <input id="name" type="text" class="form-control border-0" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Ім'я">
                                </div>
                                <div class="">&nbsp;</div>
                            </li>

                        <li class="list-group-item d-flex flex-row">
                            <div class="">&nbsp;</div>
                            <div class="d-flex flex-column">
                                <label for="surname" class="col-form-label">Прізвище</label>
                                <input id="surname" type="text" class="form-control border-0" name="surname" value="{{ old('surname') }}" required autocomplete="surname" autofocus placeholder="Прізвище">
                            </div>
                            <div class="">&nbsp;</div>
                        </li>

                        <li class="list-group-item d-flex flex-row">
                            <div class="">&nbsp;</div>
                            <div class="d-flex flex-column">
                                <label for="id_role" class="col-form-label">Роль</label>
                                <select id="id_role" class="form-control border-0" name="id_role">
                                    <option {{old('id_role') == 'Виконавець' ? 'selected' : ''}}>Виконавець</option>
                                    <option {{old('id_role') == 'Замовник' ? 'selected' : ''}}>Замовник</option>
                                </select>
                            </div>
                            <div class="">&nbsp;</div>
                        </li>

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
                    </ul>
                    <div class="form-group row mt-5">
                        <div class="col-lg-5 col-12">
                            <button type="submit" class="btn text-white badge-pill w-100 bg-violet">
                                Реєстрація
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>-->
@endsection

@section('footer')
    @include('site.footer')
@endsection
