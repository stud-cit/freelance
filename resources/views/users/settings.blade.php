@extends('layouts.site')

@section('header')
    @include('site.header')
@endsection

@section('content')

@php($categories = $data['categories'])
@php($dept = $data['dept'])
@php($types = $data['types'])

<div>
    <div class="flash-message fixed-bottom text-center">
        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
            @if(Session::has('alert-' . $msg))
                <p class="alert alert-{{ $msg }} alert-dismissible"> {{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
            @endif
        @endforeach
    </div>
    <div class="container-fluid bg-orange text-white text-center font-weight-bold font-size-40">
        Налаштування
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <form method="POST" action="{{ Auth::user()->id_role == 2 ? route('save_settings') : route('save_skills') }}" class="col-10 offset-1 shadow-lg offset-1 text-white mt-4" id="save_settings">
                    @csrf
                    @if(Auth::user()->id_role == 1)
                    @endif
                    @if(Auth::user()->id_role == 2)
                        <div class="form-group row">
                            <label for="dept_type" class="col-5 offset-1 col-form-label">Тип підрозділу:</label>
                            <select id="dept_type" class="col-5 form-control border-0 bg-light-black text-white" name="dept_type">
                                <option {{old('type_dept') == 'Не обрано' ? 'selected' : ''}} value="0">Не обрано</option>
                                @foreach($dept as $key=>$item)
                                    <option id="type-{{$item[0]->id_type}}" value="{{ $key }}">{{ $key }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group row" id="dept-block">
                            <label for="id_dept" class="col-5 offset-1 col-form-label">Назва підрозділ:</label>
                            <select id="id_dept" class="col-5 form-control border-0 bg-light-black text-white" name="id_dept">
                                <option value="0" @if($data['my_dept'] == 0) selected @endif>Не обрано</option>
                                @foreach($dept as $key=>$item)
                                    @foreach($item as $value)
                                        <option class="depts type-{{$value->id_type}}" value="{{ $value->id_dept }}" @if($data['my_dept'] == $value->id_dept) selected @endif>{{ $value->name }}</option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div>
                    @endif
                    @if(Auth::user()->id_role == 3)
                        <div class="form-group row">
                            <label for="name" class="col-5 offset-1 col-form-label mt-2">Навички:</label>
                            <div class="col-5 mt-2">
                                <select id="type" class="form-control font-size-15 text-white border-0 bg-light-black">
                                    <option value="0" disabled selected>(Оберіть ваші навички)</option>
                                    @foreach($categories as $select)
                                        <option class="" value="{{ $select->id_category }}">{{ $select->name }}</option>
                                    @endforeach
                                </select>
                                <div style="display: none">
                                    <input type="text" name="categories" value="{{ $data['string'] }}">
                                </div>
                                <div class="form-group mb-2">
                                    <div class="" id="themes_block"></div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="form-group row">
                        <input type="submit" href="" class="btn text-white bg-green font-weight-bold mx-auto pointer" value="Підтвердити">
                    </div>
                    <div class="form-group row">
                        <a href="{{ route('password_change') }}" class="btn text-white font-weight-bold mb-4 mx-auto pointer">Змінити пароль</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

@endsection

@section('footer')
    @include('site.footer')
@endsection
