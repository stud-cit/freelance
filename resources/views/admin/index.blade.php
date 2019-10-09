@extends('layouts.site')

@section('header')
	@include('site.header')
@endsection

@section('content')

@php($users = $data['users'])
@php($orders = $data['orders'])

<div class="container">
    <div class="row">
        <div class="col">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link @if($errors->isEmpty())active @endif" id="nav-ban-tab" data-toggle="tab" href="#nav-ban" role="tab" aria-controls="nav-ban" aria-selected="true">Робота з користувачами</a>
                    <a class="nav-item nav-link" id="nav-orders-tab" data-toggle="tab" href="#nav-orders" role="tab" aria-controls="nav-orders" aria-selected="false">Робота з замовленнями</a>
                    <a class="nav-item nav-link @if(!$errors->isEmpty())active @endif" id="nav-register-tab" data-toggle="tab" href="#nav-register" role="tab" aria-controls="nav-register" aria-selected="false">Реєстрація користувачів</a>
                    <a class="nav-item nav-link" id="nav-dept-tab" data-toggle="tab" href="#nav-dept" role="tab" aria-controls="nav-dept" aria-selected="false">Редагування кафедр</a>
                    <a class="nav-item nav-link" id="nav-categories-tab" data-toggle="tab" href="#nav-categories" role="tab" aria-controls="nav-categories" aria-selected="false">Редагуваня категорій</a>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade @if($errors->isEmpty())show active @endif" id="nav-ban" role="tabpanel" aria-labelledby="nav-ban-tab">
                    <div class="container">
                        @foreach($users as $ban)
                            <form action="{{ $ban->banned ? route('unban') : route('ban') }}" method="POST" class="col-9">
                                @csrf
                                <div class="d-flex flex-row mb-3 mt-2 pointer to-profile" data-id="{{$ban->id_user}}">
                                    <div class="col-1 px-0 min-width-90">
                                        <img src="{{$ban->avatar}}" class="mt-1 square-80 avatar square">
                                    </div>
                                    <div class="col-11 shadow bg-white" data-id="{{$ban->id_user}}">
                                        <div class="flex-row">
                                            <div class="font-weight-bold font-size-18 mt-2"><span data-id="{{$ban->id_user}}">{{$ban->name}} {{$ban->surname}}</span></div>
                                            <div class="text-right font-size-10">Дата реєстрації: {{$ban->created_at}}</div>
                                        </div>
                                        <div class="col-2 offset-10">
                                            @if(!$ban->banned)
                                                <button type="submit" class="btn btn-danger my-2" name="ban" value="{{$ban->id_user}}">Заблокувати</button>
                                            @else
                                                <button type="submit" class="btn my-2 bg-blue text-white" name="ban" value="{{$ban->id_user}}">Розблокувати</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @endforeach
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-orders" role="tabpanel" aria-labelledby="nav-orders-tab">
                    <div class="container orders" id="orders-list">
                        @if(count($orders))
                            @foreach($orders as $all)
                                <div class="col-9 flex-row mb-3 mt-2 d-flex">
                                    <div class="col-12 shadow bg-white work-order pointer" data-id="{{$all->id_order}}">
                                        <div class="font-weight-bold mt-2 order-title">{{$all->title}}</div>
                                        <div>{{strlen($all->description) > 50 ? substr($all->description, 0, 50) . '...' : $all->description}}</div>
                                        <div class="text-right font-size-10">Створено: {{$all->created_at}}</div>
                                        <div class="row mt-2">
                                            <div class="col-2 offset-8">
                                                @if($all->status == 'in progress')
                                                    <form action="{{ route('finish') }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn bg-blue text-white mb-2" name="finish" value="{{$all->id_order}}">Завершити</button>
                                                    </form>
                                                @endif
                                            </div>
                                            <div class="col-2">
                                                <form action="{{ route('delete') }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger mb-2" name="delete" value="{{$all->id_order}}">Видалити</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="flex-row">
                                <div class="col font-weight-bold font-size-18 text-center mt-4">Немає залишених замовленнь</div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="tab-pane fade @if(!$errors->isEmpty())show active @endif" id="nav-register" role="tabpanel" aria-labelledby="nav-register-tab">
                    <div class="container">
                        <form method="POST" action="{{ route('new_user') }}" class="col-7 mt-3">
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

                                <li class="list-group-item d-flex flex-row">
                                    <div class="">&nbsp;</div>
                                    <div class="d-flex flex-column">
                                        <label for="name" class="col-form-label">Пароль</label>
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror border-0" name="password" required autocomplete="new-password" placeholder="********">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="">&nbsp;</div>
                                </li>

                                <li class="list-group-item d-flex flex-row">
                                    <div class="">&nbsp;</div>
                                    <div class="d-flex flex-column">
                                        <label for="name" class="col-form-label">Повторіть пароль</label>

                                        <input id="password-confirm" type="password" class="form-control border-0" name="password_confirmation" required autocomplete="new-password" placeholder="********">
                                    </div>
                                    <div class="">&nbsp;</div>
                                </li>

                            </ul>

                            <div class="form-group row mt-5">
                                <div class="col-6 offset-3">
                                    <button type="submit" class="btn text-white badge-pill w-100 bg-violet">
                                        Реєстрація
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-dept" role="tabpanel" aria-labelledby="nav-dept-tab">
                    <div class="container" id="dept">
                        <form action="">
                            <div class="toggle-box">
                                <div class="form-row input-group">
                                    @php($i=0)
                                    <input type="text" class="form-control col-10" id="dept-{{ $i }}">
                                    <input type="button" class="btn-outline-primary form-control col-1 toggle-plus" value="+">
                                </div>
                            </div>
                            <button class="btn bg-violet badge-pill text-white float-right">Підтвердити</button>
                        </form>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-categories" role="tabpanel" aria-labelledby="nav-categories-tab">
                    <div class="container" id="cat">
                        <form action="">
                            <div class="toggle-box">
                                <div class="form-row input-group">
                                    @php($i=0)
                                    <input type="text" class="form-control col-10" id="cat-{{ $i }}">
                                    <input type="button" class="btn-outline-primary form-control col-1 toggle-plus" value="+">
                                </div>
                            </div>
                            <button class="btn bg-violet badge-pill text-white float-right">Підтвердити</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="flash-message fixed-bottom text-center">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
        @if(Session::has('alert-' . $msg))
            <p class="alert alert-{{ $msg }} alert-dismissible"> {{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
        @endif
    @endforeach
</div>

@endsection

@section('footer')
    @include('site.footer')
@endsection
