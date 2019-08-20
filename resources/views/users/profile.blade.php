@extends('layouts.site')

@section('header')
    @include('site.header')
@endsection

@section('content')



<div class="container">
    <div class="row">
        <div class="flash-message fixed-bottom text-center">
            @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                @if(Session::has('alert-' . $msg))

                    <p class="alert alert-{{ $msg }} alert-dismissible"> {{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                @endif
            @endforeach
        </div>
        <div class="col-9 tab-content" id="v-pills-tabContent">
            <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-home-tab">
                <div class="row">
                    <div class="col-5">
                        <img src="{{Auth::user()->getAvatarPath()}}">
                    </div>
                    <div class="col-7">
                        <div class="row text-white bg-deep-blue pt-4 pb-5">
                            <div class="col-11 name surname font-weight-bold font-size-18">{{$data->name}} {{$data->surname}}</div>
                            <div class="col-11 font-size-10 ">comp order: 7</div>
                            <div class="col-11 font-weight-bold font-size-10">Контактна інформація</div>
                            <div class="col-11 font-size-10">E-mail: {{$data->email}}</div>
                            <div class="col-11 font-size-10">Phone number: {{$data->phone_number}}</div>
                            <div class="col-11 font-size-10">Viber: {{$data->viber}}</div>
                            <div class="col-11 font-size-10">Skype: {{$data->skype}}</div>
                            <div class="col-11 font-weight-bold font-size-10">Дата реєстрації: {{$data->created_at}}</div>
                        </div>
                    </div>
                </div>
                <div class="col-9 rounded shadow-lg mt-3">
                    <label class="font-weight-bold font-size-18">Додаткова інформація</label>
                    <div class="font-size-10">{{$data->about_me}}</div>
                </div>
            </div>
            <div class="tab-pane fade" id="v-pills-portfolio" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                Оно точно нам надо?
            </div>
            <div class="tab-pane fade" id="v-pills-auth" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                <label class="col font-size-18">Налаштування безпеки</label>
                <form method="POST" action="{{route('save_info')}}" class="row" onsubmit="event.preventDefault(); var pass=$('input[name=\'new_password\']'), new_pass=$('input[name=\'new_password_confirmation\']');  if(pass.val() != new_pass.val()) { new_pass.addClass('is-invalid');return false; } else { new_pass.removeClass('is-invalid'); submit(); return true; }">
                    @csrf
                    <div class="col-9">
                        <div class="form-group row">
                            <label class="col-5 col-form-label mt-2">Старий пароль:</label>
                            <div class="col-6 mt-2">
                                <input type="password" class="form-control" name="old_password" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-5 col-form-label mt-2">Новий пароль:</label>
                            <div class="col-6 mt-2">
                                <input type="password" class="form-control" name="new_password" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-5 col-form-label mt-2">Повторіть новий пароль:</label>
                            <div class="col-6 mt-2">
                                <input type="password" class="form-control" name="new_password_confirmation" required>
                                <div class="invalid-feedback">
                                    Паролі не співпадають
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <button type="submit" class="col-4 offset-6 text-white btn badge-pill bg-deep-blue mb-2 px-0" name="form_password">Підтвердити</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="tab-pane fade" id="v-pills-edit" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-edit-tab" data-toggle="tab" href="#nav-edit" role="tab" aria-controls="nav-edit" aria-selected="true">Про мене</a>
                        <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Контакти</a>
                        <a class="nav-item nav-link" id="nav-skills-tab" data-toggle="tab" href="#nav-skills" role="tab" aria-controls="nav-skills" aria-selected="false">Навички</a>
                        <a class="nav-item nav-link" id="nav-about-tab" data-toggle="tab" href="#nav-about" role="tab" aria-controls="nav-about" aria-selected="false">Додаткова інформація</a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active row" id="nav-edit" role="tabpanel" aria-labelledby="nav-edit-tab">
                        <label class="col font-size-18 mt-2 ">Параметри</label>
                        <hr class="my-0 border-dark">
                        <form method="POST" action="{{ route('save_info') }}" class="col-6 offset-1" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row">
                                <label>Аватар:</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="avatar" id="avatar-input" lang="ua" accept="image/*">
                                    <label class="custom-file-label" for="avatar-input" id="avatar-input-label" data-browse="Обрати">Виберіть файл</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-5 col-form-label mt-2">Прізвище:</label>
                                <div class="col-6 mt-2">
                                    <input type="text" class="form-control" name="surname" value="{{$data->surname}}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-5 col-form-label mt-2">Ім'я:</label>
                                <div class="col-6 mt-2">
                                    <input type="text" class="form-control" name="name" value="{{$data->name}}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-5 col-form-label mt-2">По батькові:</label>
                                <div class="col-6 mt-2">
                                    <input type="text" class="form-control" name="patronymic" value="{{$data->patronymic}}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-5 col-form-label mt-2">Дата народження:</label>
                                <div class="col-6 mt-2">
                                    <input type="date" class="form-control" name="birthday_date" value="{{$data->birthday_date}}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-5 col-form-label mt-2">Країна:</label>
                                <div class="col-6 mt-2">
                                    <input type="text" class="form-control" name="country" value="{{$data->country}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-5 col-form-label mt-2">Місто:</label>
                                <div class="col-6 mt-2">
                                    <input type="text" class="form-control" name="city" value="{{$data->city}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <button type="submit" class="col-4 offset-6 text-white btn badge-pill bg-deep-blue mb-2 px-0" name="form_info">Підтвердити</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                        <form method="POST" action="{{route('save_info')}}" class="col-6 offset-1">
                            @csrf
                            <label class="col font-size-18 mt-2 px-0">Контакти</label>
                            <div class="form-group row">
                                <label class="col-5 col-form-label mt-2">Номер телефону:</label>
                                <div class="col-6 mt-2">
                                    <input type="text" class="form-control" name="phone_number" value="{{$data->phone_number}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-5 col-form-label mt-2">Viber:</label>
                                <div class="col-6 mt-2">
                                    <input type="text" class="form-control" name="viber" value="{{$data->viber}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-5 col-form-label mt-2">Skype:</label>
                                <div class="col-6 mt-2">
                                    <input type="text" class="form-control" name="skype" value="{{$data->skype}}">
                                </div>
                            </div>
                            <!--<div class="form-group row">
                                <label class="col-5 col-form-label mt-2">Facebook:</label>
                                <div class="col-6 mt-2">
                                    <input type="text" class="form-control" name="facebook" value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-5 col-form-label mt-2">Telegram:</label>
                                <div class="col-6 mt-2">
                                    <input type="text" class="form-control" name="telegram" value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-5 col-form-label mt-2">Instagram:</label>
                                <div class="col-6 mt-2">
                                    <input type="text" class="form-control" name="instagram" value="">
                                </div>
                            </div>-->
                            <div class="form-group row">
                                <button type="submit" class="col-4 offset-6 text-white btn badge-pill bg-deep-blue mb-2 px-0" name="form_contacts">Підтвердити</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="nav-skills" role="tabpanel" aria-labelledby="nav-skills-tab">
                        <form method="POST" action="{{route('save_info')}}" class="col">
                            @csrf
                            <label class="col font-size-18 mt-2 px-0">Спеціалізація</label>
                            <select class="col custom-select mb-2" name="custom-select">
                                <option selected>&#8213;</option>
                                <option value="1">1</option>
                                <option value="1">1</option>
                            </select>
                            <select class="col custom-select mb-2" name="custom-select">
                                <option selected>&#8213;</option>
                                <option value="1">1</option>
                                <option value="1">1</option>
                            </select>
                            <label class="col font-size-18 mt-2 px-0">Навички та вміння</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                    C++
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck2">
                                <label class="form-check-label" for="defaultCheck2">
                                    C#
                                </label>
                            </div>
                            <div class="form-group row">
                                <button type="submit" class="col-4 offset-6 text-white btn badge-pill bg-deep-blue mb-2 px-0" name="form_skills">Підтвердити</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">
                        <label class="col font-size-18 mt-2">Додаткова інформація</label>
                        <form method="POST" action="{{route('save_info')}}" class="col">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-3">
            <div class="card text-center px-0 mb-4">
                <div class="card-header text-white font-weight-bold font-size-18 c_rounded-top bg-blue">Моя сторінка</div>
                <div class="card-body">
                    <div class="nav flex-column" id="profile-bar" role="tablist" aria-orientation="vertical">
                        <ul class="list-group list-group-flush mw-100">
                            <li class="list-group-item py-0">
                                <a class="nav-link" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-edit" role="tab" aria-selected="false">Редагування даних</a>
                            </li>
                            <li class="list-group-item py-0">
                                <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-portfolio" role="tab" aria-controls="v-pills-profile" aria-selected="false">Портфоліо</a>
                            </li>
                            <li class="list-group-item py-0">
                                <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-auth" role="tab" aria-controls="v-pills-messages" aria-selected="false">Налаштування безпеки</a>
                            </li>
                            <li class="list-group-item py-0">
                                <a class="nav-link active" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-settings" aria-selected="true">Перегляд профілю</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection

@section('footer')
    @include('site.footer')
@endsection
