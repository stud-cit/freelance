@extends('layouts.site')

@section('header')
    @include('site.header')
@endsection

@section('content')
<div class="d-none" id="my_id" data-id="{{ Auth::id() }}"></div>
<div class="d-flex h-100">
    <div class="flex-column w-25" style="overflow-y: scroll" id="contacts-list">
        @php($i = 0)
        @foreach($data as $one)
            <div class="bg-light {{ $i++ ? '' : 'open_contact' }} pointer open-contact" data-id="{{ $one->id }}">
                <img src="{{ $one->avatar }}" class="square-100 avatar circle"> {{ $one->name }} {{ $one->surname }}
            </div>
        @endforeach
    </div>
    <div class="w-75">
        <div class="w-100">
            <form action="{{ route('new_message') }}" id="chat-form" method="post">
                @csrf
                <div class="input-group">
                    <input type="text" class="form-control col-11" name="text" id="message_input">
                    <button class="form-control bg-blue text-white col-1"> > </button>
                </div>
            </form>
        </div>
        <div class="d-flex flex-column h-100" style="overflow-y: scroll" id="messages-list">
            @foreach($messages as $one)
                <div class="flex-row">
                    <div class="{{$one->id_from == Auth::id() ? 'float-left' : 'float-right'}} bg-light m-2 p-2">
                        {{ $one->text }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@section('footer')
    @include('site.footer')
@endsection
