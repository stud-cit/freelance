@extends('layouts.site')

@section('header')
    @include('site.header')
@endsection

@section('content')

@php($data = $info['data'])
@php($reviews = $info['reviews'])
@php($dept = $info['dept'])

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
                    <img src="{{ $data->avatar }}" class="square square-330 avatar">
                </div>
                <div class="col">
                    <div class="row text-white bg-deep-blue pt-4 pb-5 h-100">
                        <div class="col-11 name surname font-weight-bold font-size-18">{{ $data->name }} {{ $data->surname }}</div>
                        @if(!is_null($dept))
                            <div class="col-11 name surname font-weight-bold font-size-10 font-italic">{{ $dept->name }}</div>
                        @endif
                        <div class="col-11 font-size-10">
                            @foreach($data->categories as $tags)
                                <span class="tags font-italic">{{ $tags->name }}</span>
                            @endforeach
                        </div>
                        <div class="col-11 font-weight-bold">Контактна інформація:</div>
                        <div class="container">
                            <div class="row">
                                <div class="col-6 font-size-10">E-mail: {{ $data->email }}</div>
                                <div class="col-5 font-size-10">Phone number: {{ $data->phone_number }}</div>
                                <div class="col-6 font-size-10">Viber: {{ $data->viber }}</div>
                                <div class="col-5 font-size-10">Skype: {{ $data->skype }}</div>
                            </div>
                        </div>
                        <div class="col-11 font-weight-bold font-size-10">Дата реєстрації: {{ $data->created_at }}</div>
                    </div>
                </div>
            </div>
            @if(!is_null($data->about_me))
                <p class="font-weight-bold font-size-18 mt-3">Додаткова інформація</p>
                <div class="">
                    <div class="col rounded pl-2 pt-2 pb-2 bg-white shadow-lg">{{ $data->about_me }}</div>
                </div>
            @endif
                @if(count($reviews) != 0)
                    <p class="font-weight-bold font-size-18 mt-2">Відгуки</p>
                    @foreach($reviews as $mark)
                        <div class="col-11 bg-white shadow-lg my-3">
                            <div class="d-flex flex-row">
                                <div class="col-1 px-0 min-width-70 mt-2 pointer to-profile" data-id="{{ $mark->id_user }}">
                                    <img src="{{ $mark->avatar }}" class="square-60 circle avatar">
                                </div>
                                <div class="col bg-blue text-white rounded px-2 my-2">
                                    <div class=" mt-2">{{ $mark->text }}</div>
                                    <hr class="col border-white mb-0">
                                    <div class="row font-size-10 mt-2 mb-2">
                                        <div class="col-3 pointer to-profile" data-id="{{ $mark->id_user }}">{{ $mark->name }} {{ $mark->surname }}</div>
                                        <div class="col-2 offset-2">Оцінка: {{ $mark->rating }}/5</div>
                                        <div class="col-2 offset-3">{{ $mark->created_at }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    {{ $reviews->links('layouts.pagination') }}
                @endif
        </div>
    </div>
</div>

@endsection

@section('footer')
    @include('site.footer')
@endsection
