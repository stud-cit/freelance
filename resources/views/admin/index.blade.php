@extends('layouts.site')

@section('header')
	@include('site.header')
@endsection

@section('content')

@php($users = $data['users'])
@php($orders = $data['orders'])

<div class="container">
    <div class="row">
        <div class="col-9">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-ban-tab" data-toggle="tab" href="#nav-ban" role="tab" aria-controls="nav-ban" aria-selected="true">Робота з користувачами</a>
                    <a class="nav-item nav-link" id="nav-orders-tab" data-toggle="tab" href="#nav-orders" role="tab" aria-controls="nav-orders" aria-selected="false">Робота з замовленнями</a>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-ban" role="tabpanel" aria-labelledby="nav-ban-tab">
                    <div class="container">
                        @foreach($users as $ban)
                            <form action="{{ $ban->banned ? route('unban') : route('ban') }}" method="POST">
                                @csrf
                                <div class="d-flex flex-row mb-3 mt-2 pointer to-profile" data-id="{{$ban->id_user}}">
                                    <div class="col-1 px-0 min-width-90">
                                        <img src="{{$ban->avatar}}" class="mt-1 square-80 avatar square">
                                    </div>
                                    <div class="col-11 shadow bg-white" data-id="{{$ban->id_user}}">
                                        <div class="flex-row">
                                            <div class="font-weight-bold font-size-18 mt-2"><span data-id="{{$ban->id_user}}">{{$ban->name}} {{$ban->surname}}</span></div>
                                            <div class="text-right font-size-10">Дата реєстрації: {{$ban->created_at}}</div>
                                        </div>
                                        <div class="col-2 offset-10">
                                            @if(!$ban->banned)
                                                <button type="submit" class="btn btn-danger my-2" name="ban" value="{{$ban->id_user}}">Заблокувати</button>
                                            @else
                                                <button type="submit" class="btn my-2 bg-blue text-white" name="ban" value="{{$ban->id_user}}">Розблокувати</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @endforeach
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-orders" role="tabpanel" aria-labelledby="nav-orders-tab">
                    <div class="container orders" id="orders-list">
                        @if(count($orders))
                            @foreach($orders as $all)
                                <div class="flex-row mb-3 mt-2 d-flex">
                                    <div class="col-12 shadow bg-white work-order pointer" data-id="{{$all->id_order}}">
                                        <div class="font-weight-bold mt-2 order-title">{{$all->title}}</div>
                                        <div>{{strlen($all->description) > 50 ? substr($all->description, 0, 50) . '...' : $all->description}}</div>
                                        <div class="text-right font-size-10">Створено: {{$all->created_at}}</div>
                                        <div class="row mt-2">
                                            <div class="col-2 offset-8">
                                                @if($all->status == 'in progress')
                                                    <form action="{{ route('finish') }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn bg-blue text-white mb-2" name="finish" value="{{$all->id_order}}">Завершити</button>
                                                    </form>
                                                @endif
                                            </div>
                                            <div class="col-2">
                                                <form action="{{ route('delete') }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger mb-2" name="delete" value="{{$all->id_order}}">Видалити</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="flex-row">
                                <div class="col font-weight-bold font-size-18 text-center mt-4">Немає залишених замовленнь</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('footer')
    @include('site.footer')
@endsection
