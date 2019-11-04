@extends('layouts.site')

@section('header')
    @include('site.header')
@endsection

@section('content')
<div class="d-flex h-100">
{{--        <div class="flex-column bg-success w-25" style="overflow-y: scroll">--}}
{{--            @for($i=0; $i< 30; $i++)--}}
{{--            <div>--}}
{{--                luke, a'm your friend--}}
{{--            </div>--}}
{{--            @endfor--}}
{{--        </div>--}}
        <div class="w-75 h-100">
            <div class="w-100">
                <form action="{{ route('new_message') }}" id="chat-form" method="post">
                    @csrf
                    <div class="input-group">
                        <input type="text" class="d-none" value="{{ 2 }}" name="id_to">
                        <input type="text" class="form-control col-11" name="text">
                        <button class="form-control bg-blue text-white col-1"> > </button>
                    </div>
                </form>
            </div>
{{--            <div class="d-flex flex-column " style="overflow-y: scroll">--}}
{{--                @for($i=0; $i< 30; $i++)--}}
{{--                    <div class="flex-row">--}}
{{--                        <div class="float-left bg-primary m-2 p-2">--}}
{{--                            III!--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="flex-row">--}}
{{--                        <div class="float-right bg-primary m-2 p-2">--}}
{{--                            YOUUU!--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                @endfor--}}
{{--            </div>--}}
        </div>
</div>
@endsection

@section('footer')
    @include('site.footer')
@endsection
