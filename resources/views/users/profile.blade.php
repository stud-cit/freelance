@extends('layouts.site')

@section('header')
    @include('site.header')
@endsection

@section('content')

@php($data = $info['data'])
@php($reviews = $info['reviews'])
@php($categories = $info['categories'])
@php($skills = $info['skills'])
@php($orders = $info['orders'])
@php($proposals = $info['proposals'])


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
                <div class="d-flex flex-row">
                    <div class="col-5 px-0">
                        <img src="{{Auth::user()->getAvatarPath()}}" class="square square-330 avatar">
                    </div>
                    <div class="col-7 px-0">
                        <div class="row text-white bg-deep-blue pt-4 pb-5 h-100">
                            <div class="col-11 name surname font-weight-bold font-size-18">{{$data->name}} {{$data->surname}}</div>
                            <div class="col-11 font-size-10 ">comp order: 7</div>
                            <div class="col-11 font-weight-bold">Контактна інформація:</div>
                            <div class="container">
                                <div class="row">
                                    <div class="col-6 font-size-10">E-mail: {{$data->email}}</div>
                                    <div class="col-5 font-size-10">Phone number: {{$data->phone_number}}</div>
                                    <div class="col-6 font-size-10">Viber: {{$data->viber}}</div>
                                    <div class="col-5 font-size-10">Skype: {{$data->skype}}</div>
                                </div>
                            </div>
                            <div class="col-11 font-weight-bold font-size-10">Дата реєстрації: {{$data->created_at}}</div>
                        </div>
                    </div>
                </div>
                <div class="col rounded shadow-lg mt-3">
                    <p class="font-weight-bold font-size-18">Додаткова інформація</p>
                    <div class="pb-2">{{$data->about_me}}</div>
                </div>
                @foreach($reviews as $mark)
                    <div class="col shadow-lg mt-3">
                        <p class="font-weight-bold font-size-18">Відгуки</p>
                        <div class="d-flex flex-row">
                            <div class="col-1 px-0 min-width-70">
                                <img src="{{$mark->avatar}}" class="square-60 circle avatar">
                            </div>
                            <div class="col bg-blue text-white rounded pt-2 pb-2 mb-2">
                                <div class=" mt-2">{{$mark->text}}</div>
                                <hr class="col border-white mb-0">
                                <div class="row font-size-10 mt-2 mb-2">
                                    <div class="col-3">{{$mark->name}} {{$mark->surname}}</div>
                                    <div class="col-2 offset-1">Оцінка: {{$mark->rating}}/5</div>
                                    <div class="col-2 offset-4">{{$mark->created_at}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="tab-pane fade" id="v-pills-portfolio" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                {{--Portfolio--}}
            </div>
            <div class="tab-pane fade" id="v-pills-auth" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                <p class="col font-size-18">Налаштування безпеки</p>
                <form method="POST" action="{{route('save_info')}}" class="row pass_change">
                    @csrf
                    <div class="col-9">
                        <div class="form-group row">
                            <label for="new_password" class="col-5 col-form-label mt-2">Новий пароль:</label>
                            <div class="col-6 mt-2">
                                <input type="password" id="new_password" class="form-control" name="new_password" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="new_password_confirmation" class="col-5 col-form-label mt-2">Повторіть новий пароль:</label>
                            <div class="col-6 mt-2">
                                <input type="password" id="new_password_confirmation" class="form-control" name="new_password_confirmation" required>
                                <div class="invalid-feedback">
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
                        <p class="col font-size-18 mt-2 ">Параметри</p>
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
                                <label for="surname" class="col-5 col-form-label mt-2">Прізвище:</label>
                                <div class="col-6 mt-2">
                                    <input type="text" id="surname" class="form-control" name="surname" value="{{$data->surname}}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-5 col-form-label mt-2">Ім'я:</label>
                                <div class="col-6 mt-2">
                                    <input type="text" id="name" class="form-control" name="name" value="{{$data->name}}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="patronymic" class="col-5 col-form-label mt-2">По батькові:</label>
                                <div class="col-6 mt-2">
                                    <input type="text" id="patronymic" class="form-control" name="patronymic" value="{{$data->patronymic}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="birthday_date" class="col-5 col-form-label mt-2">Дата народження:</label>
                                <div class="col-6 mt-2">
                                    <input type="date" id="birthday_date" class="form-control" name="birthday_date" value="{{$data->birthday_date}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="country" class="col-5 col-form-label mt-2">Країна:</label>
                                <div class="col-6 mt-2">
                                    <input type="text" id="country" class="form-control" name="country" value="{{$data->country}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="city" class="col-5 col-form-label mt-2">Місто:</label>
                                <div class="col-6 mt-2">
                                    <input type="text" id="city" class="form-control" name="city" value="{{$data->city}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <button type="submit" class="col-4 offset-6 text-white btn badge-pill bg-deep-blue mb-2 px-0" name="form_info">Підтвердити</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                        <form method="POST" action="{{route('save_info')}}" class="col-6">
                            @csrf
                            <p class="col font-size-18 mt-2 px-0">Контакти</p>
                            <div class="form-group row">
                                <label for="phone_number" class="col-5 col-form-label mt-2">Номер телефону:</label>
                                <div class="col-6 mt-2">
                                    <input type="text" id="phone_number" class="form-control" name="phone_number" value="{{$data->phone_number}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="viber" class="col-5 col-form-label mt-2">Viber:</label>
                                <div class="col-6 mt-2">
                                    <input type="text" id="viber" class="form-control" name="viber" value="{{$data->viber}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="skype" class="col-5 col-form-label mt-2">Skype:</label>
                                <div class="col-6 mt-2">
                                    <input type="text" id="skype" class="form-control" name="skype" value="{{$data->skype}}">
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
                            <p class="col font-size-18 mt-2 px-0">Навички та вміння</p>
                            <div class="col-9 mt-2">
                                <select name="type" id="type" class="form-control">
                                    <option value="0" disabled selected>(Оберіть навички)</option>
                                    @foreach($categories as $select)
                                        <option value="{{$select->id_category}}">{{$select->name}}</option>
                                    @endforeach
                                </select>
                                <div style="display: none">
                                    <input type="text" name="categories" value="{{$skills}}">
                                </div>
                                <div class="form-group row">
                                    <div class="col-7" id="themes_block"></div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <button type="submit" class="col-3 offset-6 text-white btn badge-pill bg-deep-blue mb-2 px-0" name="form_skills">Підтвердити</button>
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
            <div class="tab-pane fade" id="v-pills-orders" role="tabpanel" aria-labelledby="v-pills-orders-tab">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-all-tab" data-toggle="tab" href="#nav-all-c" role="tab" aria-controls="nav-all" aria-selected="true">Залишені замовлення</a>
                        <a class="nav-item nav-link" id="nav-active-tab" data-toggle="tab" href="#nav-active-c" role="tab" aria-controls="nav-active" aria-selected="false">Активні проекти</a>
                        <a class="nav-item nav-link" id="nav-complete-tab" data-toggle="tab" href="#nav-complete-c" role="tab" aria-controls="nav-complete" aria-selected="false">Завершені проекти</a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active row" id="nav-all-c" role="tabpanel" aria-labelledby="nav-all-tab">
                        @php($i = 0)
                        @foreach($orders as $all)
                            @if($all->status == 'new')
                                @php($i++)
                                <div class="container">
                                    <div class="row">
                                        <div class="col-11 mt-4 shadow-lg work-order pointer" data-id="{{$all->id_order}}">
                                            <div class="offset-1 font-weight-bold font-size-18 mt-1">{{$all->title}}</div>
                                            <div class="offset-1">{{$all->description}}</div>
                                            <div class="col offset-9 font-size-10">Дата створення: {{$all->created_at}}</div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        @if(!$i)
                            <div class="container">
                                <div class="row">
                                    <div class="col font-weight-bold font-size-18 text-center mt-4">Немає активних замовленнь</div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="tab-pane fade row" id="nav-active-c" role="tabpanel" aria-labelledby="nav-active-tab">
                        @php($i = 0)
                        @foreach($orders as $active)
                            @if($active->status == 'in progress')
                                @php($i++)
                                <div class="container">
                                    <div class="row">
                                        <div class="col-11 mt-4 shadow-lg work-order pointer" data-id="{{$active->id_order}}">
                                            <div class="offset-1 font-weight-bold font-size-18 mt-1">{{$active->title}}</div>
                                            <div class="offset-1">{{$active->description}}</div>
                                            <div class="col offset-9 font-size-10">Дата створення: {{$active->created_at}}</div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        @if(!$i)
                            <div class="container">
                                <div class="row">
                                    <div class="col font-weight-bold font-size-18 text-center mt-4">Немає активних замовленнь</div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="tab-pane fade row" id="nav-complete-c" role="tabpanel" aria-labelledby="nav-complete-tab">
                        @php($i = 0)
                        @foreach($orders as $complete)
                            @if($complete->status == 'complete')
                                @php($i++)
                                <div class="container">
                                    <div class="row">
                                        <div class="col-11 mt-4 shadow-lg work-order pointer" data-id="{{$complete->id_order}}">
                                            <div class="offset-1 font-weight-bold font-size-18 mt-1">{{$complete->title}}</div>
                                            <div class="offset-1 mb-1">{{$complete->description}}</div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        @if(!$i)
                            <div class="container">
                                <div class="row">
                                    <div class="col font-weight-bold font-size-18 text-center mt-4">Немає активних замовленнь</div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="v-pills-proposals" role="tabpanel" aria-labelledby="v-pills-proposals-tab">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-all-tab" data-toggle="tab" href="#nav-all-w" role="tab" aria-controls="nav-all" aria-selected="true">Залишені пропозиції</a>
                        <a class="nav-item nav-link" id="nav-active-tab" data-toggle="tab" href="#nav-active-w" role="tab" aria-controls="nav-active" aria-selected="false">Активні проекти</a>
                        <a class="nav-item nav-link" id="nav-complete-tab" data-toggle="tab" href="#nav-complete-w" role="tab" aria-controls="nav-complete" aria-selected="false">Завершені проекти</a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active row" id="nav-all-w" role="tabpanel" aria-labelledby="nav-all-tab">
                        @php($i = 0)
                        @foreach($proposals as $all)
                            @if($all->status == 'new')
                                @php($i++)
                                <div class="container">
                                    <div class="row">
                                        <div class="col-11 mt-4 shadow-lg work-order pointer" data-id="{{$all->id_order}}">
                                            <div class="offset-1 font-weight-bold font-size-18 mt-1">{{$all->title}}</div>
                                            <div class="offset-1">{{$all->text}}</div>
                                            <div class="col offset-9 font-size-10">Дата створення: {{$all->created_at}}</div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        @if(!$i)
                            <div class="container">
                                <div class="row">
                                    <div class="col font-weight-bold font-size-18 text-center mt-4">Немає активних замовленнь</div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="tab-pane fade row" id="nav-active-w" role="tabpanel" aria-labelledby="nav-active-tab">
                        @php($i = 0)
                        @foreach($proposals as $active)
                            @if($active->status == 'in progress')
                                @php($i++)
                                <div class="container">
                                    <div class="row">
                                        <div class="col-11 mt-4 shadow-lg work-order pointer" data-id="{{$active->id_order}}">
                                            <div class="offset-1 font-weight-bold font-size-18 mt-1">{{$active->title}}</div>
                                            <div class="offset-1">{{$active->text}}</div>
                                            <div class="col offset-9 font-size-10">Дата створення: {{$active->created_at}}</div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        @if(!$i)
                            <div class="container">
                                <div class="row">
                                    <div class="col font-weight-bold font-size-18 text-center mt-4">Немає активних замовленнь</div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="tab-pane fade row" id="nav-complete-w" role="tabpanel" aria-labelledby="nav-complete-tab">
                        @php($i = 0)
                        @foreach($proposals as $complete)
                            @if($complete->status == 'complete')
                                @php($i++)
                                <div class="container">
                                    <div class="row">
                                        <div class="col-11 mt-4 shadow-lg">
                                            <div class="offset-1 font-weight-bold font-size-18 mb-2 mt-1">{{$complete->title}}</div>
                                            <div>
                                                <div class="row">
                                                    <button class="col-3 offset-8 text-white btn badge-pill bg-deep-blue mb-2 px-0" data-toggle="collapse" data-target="#id-{{$complete->id_proposal}}">Залишити коментар</button>
                                                </div>
                                            </div>
                                            <div id="id-{{$complete->id_proposal}}" class="collapse">
                                                <form method="POST" action="" class="col shadow-lg c_rounded">
                                                    @csrf
                                                    <input name="cancel_check" style="display: none">
                                                    <div class="form-group row">
                                                        <p class="col-2 mt-3">Без відгуку:</p>
                                                        <div class="col-3 mt-3">
                                                            <input type="checkbox" id="" class="form-check-input disable-comment">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <p class="col-2">Оцінка:</p>
                                                        <div class="col-3 rating">
                                                            <input type="range" id="rating" class="reviews-rating" name="rating" min="1" max="5" step="0.5" value="3">
                                                        </div>
                                                        <div class="">
                                                            <span id="rating_val">3</span>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="comment" class="col-1 col-form-label">Коментар:</label>
                                                        <div class="col offset-1">
                                                            <textarea id="comment" class="form-control reviews-comment" rows="3" name="text" required></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <button type="submit" class="col-3 offset-8 text-white btn badge-pill bg-deep-blue mb-2 px-0" name="leave_review">Підтвердити</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        @if(!$i)
                            <div class="container">
                                <div class="row">
                                    <div class="col font-weight-bold font-size-18 text-center mt-4">Немає активних замовленнь</div>
                                </div>
                            </div>
                        @endif
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
                                <a class="nav-link active" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-settings" aria-selected="true">Перегляд профілю</a>
                            </li>
                            <li class="list-group-item py-0">
                                <a class="nav-link" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-edit" role="tab" aria-selected="false">Редагування даних</a>
                            </li>
                            <li class="list-group-item py-0">
                                <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-portfolio" role="tab" aria-controls="v-pills-profile" aria-selected="false">Портфоліо</a>
                            </li>
                            <li class="list-group-item py-0">
                                <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-auth" role="tab" aria-controls="v-pills-messages" aria-selected="false">Налаштування безпеки</a>
                            </li>
                            @if(Auth::user()->id_role == 2)
                            <li class="list-group-item py-0">
                                <a class="nav-link" id="v-pills-orders-tab" data-toggle="pill" href="#v-pills-orders" role="tab" aria-controls="v-pills-orders" aria-selected="false">Мої замовлення</a>
                            </li>
                            @elseif(Auth::user()->id_role == 3)
                            <li class="list-group-item py-0">
                                <a class="nav-link" id="v-pills-proposals-tab" data-toggle="pill" href="#v-pills-proposals" role="tab" aria-controls="v-pills-proposals" aria-selected="false">Мої пропозиції</a>
                            </li>
                            @endif
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
