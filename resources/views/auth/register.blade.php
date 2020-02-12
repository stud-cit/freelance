@extends('layouts.site')

@section('header')
    @include('site.header')
@endsection

@section('content')
    <div class="text-white" id="password_change">
        <p class="col font-size-18 text-center">Заявка на реєстрацію</p>
        <form method="POST" action="{{ route('send_application') }}" class="col-md-6 offset-md-3 col-10 offset-1 shadow-lg pass_change">
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
                    <label for="id_role " class="col-form-label">Роль</label>
                    <select id="id_role" class="form-control bg-light-black text-white border-0" name="id_role">
                        <option {{ old('id_role') == 'Виконавець' ? 'selected' : '' }}>Виконавець</option>
                        <option {{ old('id_role') == 'Замовник' ? 'selected' : '' }}>Замовник</option>
                    </select>
                </div>
                <div class="d-none form-group row" id="dept-block">
                    <label for="dept_type" class="col-form-label">Тип підрозділу:</label>
                    <select id="dept_type" class="form-control border-0 bg-light-black text-white" name="dept_type">
                        <option {{ old('type_dept') == 'Не обрано' ? 'selected' : '' }} value="0">Не обрано</option>
                        @foreach($dept as $key => $item)
                            <option id="type-{{ $item[0]->id_type }}" value="{{ $key }}">{{ $key }}</option>
                        @endforeach
                    </select>
                    <br>
                    <label for="id_dept" class="col-form-label">Назва підрозділу:</label>
                    <select id="id_dept" class="form-control border-0 bg-light-black text-white" name="id_dept">
                        <option value="0">Не обрано</option>
                        @foreach($dept as $item)
                            @foreach($item as $value)
                                <option class="depts type-{{ $value->id_type }}" value="{{ $value->id_dept }}">{{ $value->name }}</option>
                            @endforeach
                        @endforeach
                    </select>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-form-label">Електронна адреса</label>
                    <input id="email" type="email" class="form-control bg-light-black text-white @error('email') is-invalid @enderror border-0" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="email">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group row">
                    <label for="comment" class="col-form-label">Додаткова інформація</label>
                    <textarea class="form-control text-white border-0 bg-light-black" name="comment" id="comment" rows="5"></textarea>
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
