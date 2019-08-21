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
        <div class="d-flex flex-row">
            <div class="col-4">
                <img src="{{Auth::user()->getAvatarPath()}}">
            </div>
            <div class="col">
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
        <div class="col rounded shadow-lg mt-3">
            <label class="font-weight-bold font-size-18">Додаткова інформація</label>
            <div class="font-size-10">{{$data->about_me}}</div>
        </div>
    </div>
</div>



@endsection

@section('footer')
    @include('site.footer')
@endsection
