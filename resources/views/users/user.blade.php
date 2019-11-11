@extends('layouts.site')

@section('header')
    @include('site.header')
@endsection

@section('content')

@php($data = $info['data'])
@php($reviews = $info['reviews'])
@php($dept = $info['dept'])
@php($active = $info['active'])
@php($complete = $info['complete'])

<div>
    <div class="flash-message fixed-bottom text-center">
        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
            @if(Session::has('alert-' . $msg))
                <p class="alert alert-{{ $msg }} alert-dismissible"> {{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
            @endif
        @endforeach
    </div>
    <div class="d-flex flex-row align-items-center bg-light-black">
        <div class="col-2 offset-1 px-0 my-2">
            <img src="{{ $data->avatar }}" class="circle avatar" style="height: 260px; width: 260px">
        </div>
        <div class="col-6 text-white">
            <div class="col-12 name surname font-weight-bold font-size-50">{{ $data->name }} {{ $data->surname }}</div>
            @if(!is_null($dept))
                <div class="col-12 font-weight-bold font-size-35 font-italic">{{ $dept->name }}</div>
            @endif
            <div class="col-12 font-size-35">
                @foreach($data->categories as $tags)
                    <span class="tags font-italic">{{ $tags->name }}</span>
                @endforeach
            </div>
            @if(!is_null($data->about_me))
                <div class="col-12 text-gray font-size-20">{{ $data->about_me }}</div>
            @endif
        </div>
        <div class="col-2">
            @if($data->id_user != Auth::id())
                <form method="POST" action="{{ route('new_contact') }}" class="px-0">
                    @csrf
                    <button type="submit" class="btn bg-blue text-white font-weight-bold font-size-25" name="id_user" value="{{ $data->id_user }}">Відкрити приватний чат</button>
                </form>
            @endif
        </div>
    </div>
    <div class="col-12">
        <div class="d-flex flex-row justify-content-around text-white text-center">
            <div>
                <div class="font-size-100">{{$active}}</div>
                <div class="font-size-25">ACTIVE ORDERS</div>
            </div>
            <div>
                <div class="font-size-100">{{$complete}}</div>
                <div class="font-size-25">SUCCESSFULL PROJECTS</div>
            </div>
            <div>
                <div class="font-size-100">{{$active + $complete}}</div>
                <div class="font-size-25">ORDERS COUNT</div>
            </div>
        </div>
    </div>
    @if(count($reviews) != 0)
        <div class="d-flex justify-content-center my-4">
            <button class="btn badge-pill bg-orange text-center text-white" id="mark-toggle" data-toggle="collapse" data-target="#mark" aria-expanded="true">Відобразити відгуки</button>
        </div>
    <div class="collapse" id="mark">
        <div class="offset-1 col-10">
            <div class="row">
            @foreach($reviews as $mark)
                <div class="col-6 bg-deep-dark text-white">
                    <div class="d-flex flex-row align-items-center">
                        <div class="col-2 px-0 pointer to-profile" data-id="{{ $mark->id_user }}">
                            <img src="{{ $mark->avatar }}" class="circle avatar" style="height: 106px; width: 106px">
                        </div>
                        <div class="col-10 pointer to-profile" data-id="{{ $mark->id_user }}">{{ $mark->name }} {{ $mark->surname }}</div>
                    </div>
                    <div class="d-flex flex-row mb-4">
                        <div class="col-10 mt-2">{{ $mark->text }}</div>
                        <div class="col-2">
                            <div>
                                <img src="" alt="">
                            </div>
                            <div class="font-size-10">{{ $mark->created_at }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
            {{ $reviews->links('layouts.pagination') }}
            </div>
        </div>
    </div>
    @endif
</div>


@endsection

@section('footer')
    @include('site.footer')
@endsection
