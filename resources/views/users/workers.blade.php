@extends('layouts.site')

@section('header')
    @include('site.header')
@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col-9">
            <div class="font-weight-bold font-size-18">Всі виконавці</div>
            <div class="container">
                @foreach($workers as $list)
                    <div class="d-flex flex-row mb-3 mt-2 pointer to-profile">
                        <div class="col-1 px-0 min-width-70" data-id="{{$list->id_user}}">
                            <img src="{{$list->avatar}}" class="mt-1 square-60 avatar square">
                        </div>
                        <div class="col-9 shadow bg-white" data-id="{{$list->id_user}}">
                            <div class="flex-row">
                                <div class="font-weight-bold mt-2"><span class="" data-id="{{$list->id_user}}">{{$list->name}} {{$list->surname}}</span></div>
                                <div class="tag-list">
                                    @foreach($workers->categories as $tags)
                                        <span class="tags font-italic font-size-10">{{$tags->name}}</span>
                                    @endforeach
                                </div>
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
