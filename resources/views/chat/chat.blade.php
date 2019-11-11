@extends('layouts.site')

@section('header')
    @include('site.header')
@endsection

@php($id_to = $data['id_to'])
@php($messages = $data['messages'])
@php($data = $data['data'])

@section('content')
<div class="d-none" id="my_id" data-id="{{ Auth::id() }}"></div>
<div class="d-flex h-100">
    <div class="flex-column w-25" style="overflow-y: scroll" id="contacts-list">
        @foreach($data as $one)
            <div class="bg-light {{ !is_null($id_to) && $id_to == $one->id ? 'open-contact' : '' }} pointer contact" data-id="{{ $one->id }}">
                <img src="{{ $one->avatar }}" class="square-100 avatar circle">
                <span> {{ $one->name }} {{ $one->surname }} </span>
                <span class="messages-count @if(!$one->count) d-none @endif"> ({{ $one->count }}) </span>
            </div>
        @endforeach
    </div>
    <div class="w-75">
        <div class="w-100">
            <form action="{{ route('new_message') }}" id="chat-form" method="post">
                @csrf
                <div class="input-group">
                    <input type="text" class="form-control col-10 @if(is_null($id_to))d-none @endif" name="text" id="message_input">
                    <input type="file" class="form-control-file col-1 @if(is_null($id_to))d-none @endif" name="file" id="file_input">
                    <button class="form-control bg-blue text-white col-1 @if(is_null($id_to))d-none @endif"> > </button>
                </div>
            </form>
        </div>
        <div class="d-flex flex-column h-100" style="overflow-y: scroll" id="messages-list">
            @if(!is_null($messages))
                @foreach($messages as $one)
                    <div class="flex-row">
                        <div class="{{$one->id_from == Auth::id() ? 'float-left' : 'float-right'}} bg-light m-2 p-2">
                            <span title="{{ $one->created_at }}"> {{ $one->text }}</span>
                            <span class="font-italic">{{ $one->time }}</span>
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
