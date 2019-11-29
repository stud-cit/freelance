@extends('layouts.site')

@section('header')
	@include('site.header')
@endsection

@section('content')

@php($users = $data['users'])
@php($orders = $data['orders'])
@php($dept = $data['dept'])
@php($categ = $data['categ'])
@php($app = $data['app'])

<div class="container">
    <div class="row">
        <div class="col">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link @if($errors->isEmpty())active @endif" id="nav-ban-tab" data-toggle="tab" href="#nav-ban" role="tab" aria-controls="nav-ban" aria-selected="true">Робота з користувачами</a>
                    <a class="nav-item nav-link" id="nav-orders-tab" data-toggle="tab" href="#nav-orders" role="tab" aria-controls="nav-orders" aria-selected="false">Робота з замовленнями</a>
                    <a class="nav-item nav-link @if(!$errors->isEmpty())active @endif" id="nav-register-tab" data-toggle="tab" href="#nav-register" role="tab" aria-controls="nav-register" aria-selected="false">Реєстрація користувачів</a>
                    <a class="nav-item nav-link" id="nav-dept-tab" data-toggle="tab" href="#nav-dept" role="tab" aria-controls="nav-dept" aria-selected="false">Редагування кафедр</a>
                    <a class="nav-item nav-link" id="nav-categ-tab" data-toggle="tab" href="#nav-categ" role="tab" aria-controls="nav-categ" aria-selected="false">Редагування категорій</a>
                    <a class="nav-item nav-link" id="nav-applications-tab" data-toggle="tab" href="#nav-applications" role="tab" aria-controls="nav-applications" aria-selected="false">Заявки на реєстрацію</a>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade @if($errors->isEmpty())show active @endif" id="nav-ban" role="tabpanel" aria-labelledby="nav-ban-tab">
                    @foreach($users as $ban)
                        <form action="{{ $ban->banned ? route('unban') : route('ban') }}" method="POST" class="my-2">
                            @csrf
                            <div class="container shadow-box text-white mb-2">
                                <div class="d-flex flex-row justify-content-between align-items-end pointer to-profile" data-id="{{ $ban->id_user }}">
                                    <div class="d-flex flex-row">
                                        <div class="min-width-60 my-2">
                                            <img src="{{ $ban->avatar }}" class="circle avatar" style="min-width: 60px; width: 100px">
                                        </div>
                                        <div class="d-flex align-self-center font-weight-bold font-size-20 ml-2">
                                            <span class="" data-id="{{ $ban->id_user }}">{{ $ban->name }} {{ $ban->surname }}</span>
                                        </div>
                                    </div>
                                    <div class="" data-id="{{ $ban->id_user }}">
                                        <div class="d-flex flex-row">
                                            <div class="text-right font-size-10">Дата реєстрації: {{ $ban->created_at }}</div>
                                        </div>
                                        <div>
                                            @if(!$ban->banned)
                                                <button type="submit" class="btn btn-danger my-2" name="ban" value="{{ $ban->id_user }}">Заблокувати</button>
                                            @else
                                                <button type="submit" class="btn my-2 bg-blue text-white" name="ban" value="{{ $ban->id_user }}">Розблокувати</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <hr class="border-grey pb-1">
                            </div>
                        </form>
                    @endforeach
                </div>
                <div class="tab-pane fade" id="nav-orders" role="tabpanel" aria-labelledby="nav-orders-tab">
                    <div class="container orders" id="orders-list">
                        @if(count($orders))
                            @foreach($orders as $all)
                                <div class="container-fluid text-white" id="orders-list">
                                    <div class="mt-2 mb-4">
                                        <div class="container-fluid shadow-box mb-4 orders">
                                            <div class="d-flex flex-row justify-content-between align-items-center">
                                                <div class="d-flex justify-content-start">
                                                    <div class="d-flex flex-row">
                                                        <div class="font-weight-bold order-title font-size-30">{{ $all->title }}</div>
                                                        <div class="align-self-center ml-4">
                                                            @if($all->files)
                                                                <img src="{{ asset('/edit.svg') }}" alt="edit" width="20px" id="edit" title="Є прікріплені файли">
                                                            @endif
                                                        </div>
                                                        <div class="align-self-center ml-1">
                                                            @if($all->time)
                                                                <img src="{{ asset('/calendar.svg') }}" alt="calendar" width="20px" id="calendar" title="Час виконання займає {{ $all->time }}">
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="text-center font-weight-bold font-size-30 nowrap justify-content-end">{{ $all->price }}</div>
                                            </div>
                                            <div class="text-grey">{{ $all->created_at }}</div>
                                            <div class="font-size-22">{{ $all->description }}</div>

                                                <div class="d-flex flex-row justify-content-end">
                                                    <div>
                                                        @if($all->status == 'in progress')
                                                            <form action="{{ route('finish') }}" method="POST">
                                                                @csrf
                                                                <button type="submit" class="btn bg-blue text-white mr-2" name="finish" value="{{ $all->id_order }}">Завершити</button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <form action="{{ route('delete') }}" method="POST">
                                                            @csrf
                                                            <button type="submit" class="btn btn-danger" name="delete" value="{{ $all->id_order }}">Видалити</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            <hr class="border-grey pb-4">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="flex-row">
                                <div class="col font-weight-bold font-size-18 text-white text-center mt-4">Немає залишених замовленнь</div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="tab-pane fade @if(!$errors->isEmpty())show active @endif" id="nav-register" role="tabpanel" aria-labelledby="nav-register-tab">
                    <div class="container">
                        <form method="POST" action="{{ route('new_user') }}" class="col-7 mt-3 text-white">
                            @csrf
                            <ul class="list-group ">
                                <li class="list-group-item d-flex flex-row bg-light-grey">
                                    <div class="d-flex flex-column flex-grow-1">
                                        <label for="name" class="col-form-label">Ім'я</label>
                                        <input id="name" type="text" class="form-control border-0 bg-deep-dark text-white" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Ім'я">
                                    </div>
                                </li>
                                <li class="list-group-item d-flex flex-row bg-light-grey">
                                    <div class="d-flex flex-column flex-grow-1">
                                        <label for="surname" class="col-form-label">Прізвище</label>
                                        <input id="surname" type="text" class="form-control border-0 bg-deep-dark text-white" name="surname" value="{{ old('surname') }}" required autocomplete="surname" autofocus placeholder="Прізвище">
                                    </div>
                                </li>
                                <li class="list-group-item d-flex flex-row bg-light-grey">
                                    <div class="d-flex flex-column flex-grow-1">
                                        <label for="id_role" class="col-form-label">Роль</label>
                                        <select id="id_role" class="form-control border-0 bg-deep-dark text-white" name="id_role">
                                            <option {{old('id_role') == 'Виконавець' ? 'selected' : ''}} value="Виконавець">Виконавець</option>
                                            <option {{old('id_role') == 'Замовник' ? 'selected' : ''}} value="Замовник">Замовник</option>
                                        </select>
                                    </div>
                                </li>
                                <li class="list-group-item d-none flex-row bg-light-grey" id="dept-block">
                                    <div class="d-flex flex-column">
                                        <label for="id_dept" class="col-form-label">Кафедра</label>
                                        <select id="id_dept" class="form-control border-0 bg-deep-dark text-white" name="id_dept">
                                            <option {{old('id_dept') == 'Не обрано' ? 'selected' : ''}} value="0">Не обрано</option>
                                            @foreach($dept as $item)
                                                <option {{ old('id_dept') == $item->id_dept ? 'selected' : '' }} value="{{ $item->id_dept}} ">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </li>
                                <li class="list-group-item d-flex flex-row bg-light-grey">
                                    <div class="d-flex flex-column flex-grow-1">
                                        <label for="name" class="col-form-label">Електронна адреса</label>
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror border-0 bg-deep-dark text-white" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="email">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </li>
                                <li class="list-group-item d-flex flex-row bg-light-grey">
                                    <div class="d-flex flex-column flex-grow-1">
                                        <label for="name" class="col-form-label">Пароль</label>
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror border-0 bg-deep-dark text-white" name="password" required autocomplete="new-password" placeholder="********">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </li>
                                <li class="list-group-item d-flex flex-row bg-light-grey">
                                    <div class="d-flex flex-column flex-grow-1">
                                        <label for="name" class="col-form-label">Повторіть пароль</label>
                                        <input id="password-confirm" type="password" class="form-control border-0 bg-deep-dark text-white" name="password_confirmation" required autocomplete="new-password" placeholder="********">
                                    </div>
                                </li>
                            </ul>
                            <div class="form-group row mt-3">
                                <div class="col-6 offset-3">
                                    <button type="submit" class="btn text-white badge-pill w-100 bg-orange">
                                        Реєстрація
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-dept" role="tabpanel" aria-labelledby="nav-dept-tab">
                    <div class="container" id="dept" data-id="0">
                        <form action="{{ route('save_dept') }}" method="POST">
                            @csrf
                            <div class="toggle-box">
                                <div class="form-row input-group">
                                    <input type="text" class="form-control col-10" disabled>
                                    <input type="button" class="btn-outline-primary form-control col-1 toggle-plus" value="+">
                                </div>
                                @foreach($dept as $one)
                                    <div class="form-row input-group">
                                        <input type="text" class="form-control col-10" name="dept-{{ $one->id_dept }}" value="{{ $one->name }}">
                                        <input type='button' class='btn-outline-danger form-control col-1 toggle-minus' value='-'>
                                    </div>
                                @endforeach
                            </div>
                            <button type="submit" class="btn bg-orange badge-pill text-white float-right">Підтвердити</button>
                        </form>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-categ" role="tabpanel" aria-labelledby="nav-categ-tab">
                    <div class="container" id="categ" data-id="0">
                        <form action="{{ route('save_categ') }}" method="POST">
                            @csrf
                            <div class="toggle-box">
                                <div class="form-row input-group">
                                    <input type="text" class="form-control col-10" disabled>
                                    <input type="button" class="btn-outline-primary form-control col-1 toggle-plus bg-deep-dark text-white" value="+">
                                </div>
                                @foreach($categ as $one)
                                    <div class="form-row input-group">
                                        <input type="text" class="form-control col-10 bg-deep-dark text-white" name="categ-{{ $one->id_category }}" value="{{ $one->name }}">
                                        <input type='button' class='btn-outline-danger form-control col-1 toggle-minus bg-deep-dark text-white' value='-'>
                                    </div>
                                @endforeach
                            </div>
                            <button type="submit" class="btn bg-orange badge-pill text-white float-right">Підтвердити</button>
                        </form>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-applications" role="tabpanel" aria-labelledby="nav-applications-tab">
                    <div class="container orders" id="orders-list">
                        @if(count($app))
                            @foreach($app as $reg)
                                <div class="container-fluid text-white" id="orders-list">
                                    <div class="mt-2 mb-4">
                                        <div class="container-fluid shadow-box mb-4 orders">
                                            <div class="d-flex flex-row justify-content-between align-items-center">
                                                <div class="font-weight-bold order-title font-size-25">{{ $reg->name }} {{ $reg->surname }}</div>
                                                <div class="align-self-center">Роль: {{ $reg->id_role }}</div>
                                            </div>
                                            <div class="d-flex flex-row justify-content-between align-items-center">
                                                <div>{{ $reg->email }}</div>
                                                <div>Кафедра: {{ $reg->dept }}</div>
                                            </div>
                                            @if(!is_null($reg->comment))
                                                <div class="mt-2">Коментар:</div>
                                                <div>{{ $reg->comment }}</div>
                                            @endif
                                            <div class="d-flex flex-row justify-content-end mt-2">
                                                <div>
                                                    <form action="{{ route('accept_application', $reg->id_app) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn bg-green text-white mr-2 app-event">Прийняти</button>
                                                    </form>
                                                </div>
                                                <div>
                                                    <form action="{{ route('reject_application', $reg->id_app) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger app-event">Відхилити</button>
                                                    </form>
                                                </div>
                                            </div>
                                            <hr class="border-grey pb-2">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="flex-row">
                                <div class="col font-weight-bold font-size-18 text-white text-center mt-4">Немає залишених заявок</div>
                            </div>
                        @endif
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
