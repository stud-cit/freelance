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
        <div>
            <div class="d-flex flex-row">
                <div class="col-4 px-0">
                    <img src="{{$data->avatar}}" class="square square-330 avatar">
                </div>
                <div class="col">
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
                <label class="font-weight-bold font-size-18">Додаткова інформація</label>
                <div class="font-size-10">{{$data->about_me}}</div>
            </div>
            <div class="col shadow-lg mt-3">
                @foreach($reviews as $mark)
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
                @endforeach
            </div>
        </div>
    </div>
</div>



@endsection

@section('footer')
    @include('site.footer')
@endsection
