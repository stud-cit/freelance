@extends('layouts.site')

@section('header')
    @include('site.header')
@endsection

@section('content')

@foreach($data as $list)
    <div class="container shadow-box text-white mb-2">
        <div class="d-flex flex-row justify-content-between align-items-end pointer to-profile" data-id="{{ $list->id_user }}">
            <div class="d-flex flex-row">
                <div class="min-width-60 my-2">
                    <img src="{{ $list->avatar }}" class="circle avatar" style="min-width: 60px; width: 100px">
                </div>
                <div class="d-flex align-self-center font-weight-bold font-size-20 ml-2">
                    <span data-id="{{ $list->id_user }}">{{ $list->name }} {{ $list->surname }}</span>
                </div>
            </div>
            <div data-id="{{ $list->id_user }}">
                <div class="d-flex flex-row">
                    <div class="tag-list">
                        @if(!count($list->categories) && !($list->about_me))
                            &nbsp;
                        @endif
                        @foreach($list->categories as $tags)
                            <span class="tags font-italic font-size-10">{{$tags->name}}</span>
                        @endforeach
                    </div>
                    <div>{{ strlen($list->about_me) > 100 ? substr($list->about_me, 0, 100) . '...' : $list->about_me }}</div>
                    <div class="text-right font-size-10">Дата реєстрації: {{ $list->created_at }}</div>
                </div>
            </div>
        </div>
        <hr class="border-grey pb-1">
    </div>
@endforeach
{{ $data->links('layouts.pagination') }}

@endsection

@section('footer')
    @include('site.footer')
@endsection
