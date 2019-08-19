@extends('layouts.site')

@section('header')
    @include('site.header')
@endsection

@section('content')



<div class="container">
    <div class="row">
        <div class="col-9 tab-content" id="v-pills-tabContent">
            <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-home-tab">
                <div class="row">
                    <div class="col-5 px-0">
                        <img src="{{Auth::user()->getAvatarPath()}}">
                    </div>
                    <div class="col-7">
                        <div class="row text-white bg-deep-blue pt-4 pb-5">
                            <div class="col-11 name surname font-weight-bold font-size-18">Doot Doooted</div>
                            <div class="col-11 font-size-10 ">comp order: 7</div>
                            <div class="col-11 font-weight-bold font-size-10">Контактна інформація</div>
                            <div class="col-11 font-size-10">E-mail: </div>
                            <div class="col-11 font-size-10">Phone number: </div>
                            <div class="col-11 font-size-10">Viber: </div>
                            <div class="col-11 font-size-10">Skype: </div>
                            <div class="col-11 font-weight-bold font-size-10">Дата реєстрації:</div>
                        </div>
                    </div>
                </div>
                <div class="col-9 rounded shadow-lg mt-3">
                    <label class="font-weight-bold font-size-18">Додаткова інформація</label>
                    <div class="font-size-10"></div>
                </div>
            </div>
            <div class="tab-pane fade" id="v-pills-portfolio" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                Оно точно нам надо?
            </div>
            <div class="tab-pane fade" id="v-pills-auth" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                Doooot
            </div>
            <div class="tab-pane fade" id="v-pills-edit" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Home</a>
                        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Profile</a>
                        <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Contact</a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">Dooot 1</div>
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">Dooot 2</div>
                    <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">Dooot 3</div>
                </div>
            </div>

        </div>
        <div class="col-3">
            <div class="card text-center px-0 mb-4">
                <div class="card-header text-white font-weight-bold font-size-18 c_rounded-top bg-blue">Моя сторінка</div>
                <div class="card-body">
                    <div class="nav flex-column" id="profile-bar" role="tablist" aria-orientation="vertical">
                        <a class="nav-link" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-edit" role="tab" aria-selected="false">Редагування даних</a>
                        <hr style="border-color: black">
                        <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-portfolio" role="tab" aria-controls="v-pills-profile" aria-selected="false">Портфоліо</a>
                        <hr>
                        <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-auth" role="tab" aria-controls="v-pills-messages" aria-selected="false">Налаштування безпеки</a>
                        <hr>
                        <a class="nav-link active" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-settings" aria-selected="true">Перегляд профілю</a>
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
