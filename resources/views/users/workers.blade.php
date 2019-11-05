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
                @foreach($data as $list)
                    <div class="d-flex flex-row mb-3 mt-2 pointer to-profile" data-id="{{ $list->id_user }}">
                        <div class="col-1 px-0 min-width-90">
                            <img src="{{ $list->avatar }}" class="mt-1 square-80 avatar square">
                        </div>
                        <div class="col-11 shadow bg-white" data-id="{{ $list->id_user }}">
                            <div class="flex-row">
                                <div class="font-weight-bold font-size-18 mt-2"><span class="" data-id="{{ $list->id_user }}">{{ $list->name }} {{ $list->surname }}</span></div>
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
                @endforeach
            </div>
            {{ $data->links('layouts.pagination') }}
        </div>
    </div>
</div>


@endsection

@section('footer')
    @include('site.footer')
@endsection
