@extends('layouts.site')

@section('header')
    @include('site.header')
@endsection

@php($id_to = $data['id_to'])
@php($messages = $data['messages'])
@php($data = $data['data'])

@section('content')
<div class="d-none" id="my_id" data-id="{{ Auth::id() }}"></div>
<form action="{{ route('get_file') }}" method="POST" class="d-none" id="get-file-form">
    @csrf
    <input type="text" name="id">
    <input type="text" name="name">
</form>
<div class="d-flex h-100 container-fluid">
    <div class="flex-column w-25" style="overflow-y: scroll" id="contacts-list">
        @foreach($data as $one)
            <div class="bg-light {{ !is_null($id_to) && $id_to == $one->id ? 'open-contact' : '' }} pointer contact" data-id="{{ $one->id }}">
                <img src="{{ $one->avatar }}" class="square-100 avatar circle">
                <span> {{ $one->name }} {{ $one->surname }} </span>
                <span class="messages-count @if(!$one->count) d-none @endif"> ({{ $one->count }}) </span>
            </div>
        @endforeach
    </div>
    <div class="w-75 h-100">
        <div class="w-100">
            <form action="{{ route('new_message') }}" id="chat-form" method="post">
                @csrf
                <div class="input-group">
                    <input type="text" class="form-control col-10 @if(is_null($id_to))d-none @endif" name="text" id="message_input">
                    <button class="form-control bg-deep-dark text-white col-1 @if(is_null($id_to))d-none @endif" id="file_selector" onclick="$('#file_input').trigger('click')">&#128392;</button>
                    <input type="file" class="d-none" name="file" id="file_input" style="display: none !important;">
                    <button class="form-control bg-deep-dark text-white col-1 @if(is_null($id_to))d-none @endif">&#8594;</button>
                </div>
            </form>
        </div>
        <div class="d-flex flex-column" style="overflow-y: scroll; height: 95%" id="messages-list">
            @if(!is_null($messages))
                @foreach($messages as $one)
                    <div class="flex-row">
                        <div class="{{ $one->id_from == Auth::id() ? 'float-left' : 'float-right' }} {{ $one->file ? 'bg-green this-is-file pointer' : 'bg-light'}} m-2 p-2 min-width-25 rounded" data-id="{{ $one->id_message }}">
                            <span title="{{ $one->created_at }}"> {{ $one->text }}</span>
                            <br>
                            <span class="float-right font-italic">{{ $one->time }}</span>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection

@section('footer')
    @include('site.footer')
@endsection
