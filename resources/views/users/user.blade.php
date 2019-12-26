@extends('layouts.site')

@section('header')
    @include('site.header')
@endsection

@section('content')

@php($data = $info['data'])
@php($reviews = $info['reviews'])
@php($dept = $info['dept'])
@php($active = $info['active'])
@php($complete = $info['complete'])
@php($orders = $info['orders'])
@php($proposals = $info['proposals'])
@php($progress = $info['progress'])
@php($all_dept = $info['all_dept'])

<div>
    <div class="flash-message fixed-bottom text-center">
        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
            @if(Session::has('alert-' . $msg))
                <p class="alert alert-{{ $msg }} alert-dismissible"> {{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
            @endif
        @endforeach
    </div>
    <div class="collapse user_block show" id="profile-info">
        <div class="d-flex flex-row align-items-center bg-light-black">
            <div class="col-2 offset-1 px-0 my-2">
                <img src="{{ $data->avatar }}" class="circle avatar" style="height: 260px; width: 260px">
            </div>
            <div class="col-6 text-white">
                <div class="col-12 name surname font-weight-bold font-size-50">{{ $data->name }} {{ $data->surname }}</div>
                @if(!is_null($dept))
                    <div class="col-12 font-weight-bold font-size-35">{{ $dept->name }}</div>
                @endif
                <div class="col-12 font-size-35">
                    @foreach($data->categories as $tags)
                        <span class="tags">{{ $tags->name }}</span>
                    @endforeach
                </div>
                @if(!is_null($data->about_me))
                    <div class="col-12 text-gray font-size-20">{{ $data->about_me }}</div>
                @endif
            </div>
            <div class="col-2">
                @if(Auth::check() && $data->id_user != Auth::id())
                    <form method="POST" action="{{ route('new_contact') }}" class="px-0">
                        @csrf
                        <button type="submit" class="btn bg-blue text-white font-weight-bold font-size-25" name="id_user" value="{{ $data->id_user }}">Відкрити приватний чат</button>
                    </form>
                @elseif(Auth::check())
                    &nbsp;<button class="btn bg-orange text-white font-weight-bold font-size-25" data-toggle="collapse" data-target=".user_block">Редагувати профіль</button>
                @endif
            </div>
        </div>
    </div>
    <div class="collapse user_block" id="profile-edit">
        <div class="d-flex flex-row align-items-center bg-light-black">
            <div class="col-2 offset-1 px-0 my-2">
                <img src="{{ $data->avatar }}" class="circle avatar" style="height: 260px; width: 260px">
            </div>
            <div class="col-6 text-white">
                <form method="POST" action="{{ route('save_info') }}" class="col-10 offset-1 shadow-lg offset-1" id="save_info" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row mt-4">
                        <label class="col-5 col-form-label mt-2">Аватар:</label>
                        <div class="custom-file col-6 mt-2">
                            <input type="file" class="custom-file-input form-control border-0" name="avatar" id="avatar-input" lang="ua" accept="image/*">
                            <label class="custom-file-label bg-deep-dark text-white border-0 nowrap" for="avatar-input" id="avatar-input-label" data-browse="Обрати">Виберіть файл</label>
                            <div class="invalid-feedback">Зображення більше 2 Мб</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="surname" class="col-5 col-form-label mt-2">Прізвище:</label>
                        <div class="col-6 mt-2">
                            <input type="text" id="surname" class="form-control bg-deep-dark text-white border-0" name="surname" value="{{ $data->surname }}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-5 col-form-label mt-2">Ім'я:</label>
                        <div class="col-6 mt-2">
                            <input type="text" id="name" class="form-control bg-deep-dark text-white border-0" name="name" value="{{ $data->name }}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="about_me" class="col-5 col-form-label mt-2">Про мене:</label>
                        <div class="col-6 mt-2">
                            <textarea class="form-control bg-deep-dark text-white border-0" id="about_me" name="about_me" rows="6">{{ $data->about_me }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <a href="{{ route('password_change') }}" class="btn text-white font-weight-bold mb-4 mx-auto pointer">Змінити пароль</a>
                    </div>
                </form>
            </div>
            <div class="col-2 d-flex flex-row">
                @if($data->id_user != Auth::id())
                    <form method="POST" action="{{ route('new_contact') }}" class="px-0">
                        @csrf
                        <button type="submit" class="btn bg-blue text-white font-weight-bold font-size-25" name="id_user" value="{{ $data->id_user }}">Відкрити приватний чат</button>
                    </form>
                @else
                    &nbsp;<button class="btn bg-green text-white font-weight-bold font-size-25" onclick="$('#save_info').submit()">Зберегти</button>
                    &nbsp;<button class="btn text-white font-weight-bold font-size-25" data-toggle="collapse" data-target=".user_block">X</button>
                @endif
            </div>
        </div>
    </div>
    <div>
        <div class="d-flex flex-column align-items-center my-5">
            @if($data->id == Auth::id() && $data->id_role == 2)
                <a href="{{ route('my_orders') }}" class="btn col-6 bg-light-black font-size-30 font-weight-bold text-white text-center mt-4">Переглянути мої замовлення</a>
            @elseif($data->id == Auth::id() && $data->id_role == 3)
                <a href="{{ route('my_orders') }}" class="btn col-6 bg-light-black font-size-30 font-weight-bold text-white text-center mt-4">Переглянути мої пропозиції</a>
            @endif
            @if(count($reviews) != 0)
                <button class="btn col-6 bg-orange font-size-30 font-weight-bold text-center text-white my-4" id="mark-toggle" data-toggle="collapse" data-target="#mark" aria-expanded="true">Відобразити відгуки</button>
            @endif
        </div>
    </div>

    <div class="collapse bg-light-black mt-4" id="mark">
        <div class="offset-1 col-10">
            <div class="row">
            @foreach($reviews as $mark)
                <div class="col-6 bg-light-black text-white shadow-box my-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex flex-row align-items-center mt-2">
                            <div class="px-0 pointer to-profile" data-id="{{ $mark->id_user }}">
                                <img src="{{ $mark->avatar }}" class="circle avatar" style="height: 106px; width: 106px">
                            </div>
                            <div class="pointer to-profile font-size-30 ml-2" data-id="{{ $mark->id_user }}">{{ $mark->name }} {{ $mark->surname }}</div>
                        </div>
                    </div>
                    <hr class="border-grey">
                    <div class="d-flex flex-row justify-content-between mb-4">
                        <div class="mt-2 align-self-center">{{ $mark->text }}</div>
                        <div class="d-flex flex-column">
                            <div>
                                <div class="font-size-30">{{ $mark->rating }}/5</div>
                            </div>
                            <div class="d-flex">
                                <div class="font-size-10">{{ $mark->created_at }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            {{ $reviews->links('layouts.pagination') }}
            </div>
        </div>
    </div>
</div>


@endsection

@section('footer')
    @include('site.footer')
@endsection
