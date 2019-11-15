@extends('layouts.site')

@section('header')
    @include('site.header')
@endsection

@section('content')

@php($data = $info['data'])
@php($categories = $info['categories'])
@php($dept = $info['dept'])

<div class="container-fluid">
    <div class="row">
        <div class="col-10 offset-1 text-white">
            <div class="font-weight-bold font-size-40">Пошук по проектам</div>
        </div>
        <div class="col-11">
            <div class="d-flex flex-row">
                @if(!Auth::check() || Auth::user()->id_role !=2)
                    <div class="col-1"></div>
                @elseif(Auth::user()->id_role == 2 && !Auth::user()->banned)
                <div class="col-1 d-flex justify-content-end">
                    <button class="btn circle bg bg-green square-60" id="new_order-toggle" data-toggle="collapse" data-target="#new-order" aria-expanded="true">&#43;</button>
                </div>
                @endif
                <form action="" class="col-11">
                    <div class="input-group">
                        <input type="text" class="form-control" aria-label="filter" id="filter" style="height: 54px">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary bg-dark-green text-white dropdown-toggle font-size-25" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width: 250px">Кафедри</button>
                            <div class="dropdown-menu try">
                                @foreach($dept as $tags)
                                    <ul class="list-group">
                                        <a class="categories_tag dropdown-item" href="" data-id="{{ $tags->id_dept }}">{{ $tags->name }}</a>
                                    </ul>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="container collapse text-white" id="new-order" style="background-color: #303E51">
            <form method="POST" action="{{ route('save_order') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-6 mt-4">
                        <p class="font-size-35 font-weight-bold bg-orange text-center">Створення замовлення</p>
                    </div>
                </div>
                <div class="d-flex flex-row justify-content-around">
                    <div class="form-group col-5">
                        <label for="title">Назва</label>
                        <input type="text" class="form-control text-white border-0 bg-deep-dark" id="title" name="title">
                        <label for="description" class="mt-2">Інформація</label>
                        <textarea class="form-control text-white border-0 bg-deep-dark" name="description" id="description" rows="5" required></textarea>
                        <input id="add-files" type="file" class="btn badge-pill bg-white mt-2" multiple="multiple" name="files[]">
                    </div>
                    <div class="form-group col-5">
                        <label for="price">Ціна</label>
                        <div class="d-flex flex-row">
                            <input type="text" class="col-9 form-control text-white border-0 bg-deep-dark" id="price" name="price">
                            <select class="col-2 offset-1 form-control text-white border-0 bg-deep-dark" name="currency">
                                <option>грн.</option>
                                <option>$</option>
                            </select>
                        </div>
                        <label for="time" class="mt-2">Час</label>
                        <div class="d-flex flex-row">
                            <input type="text" class="col-9 form-control border-0 bg-deep-dark" id="time" name="time">
                            <select class="col-2 offset-1 form-control text-white border-0 bg-deep-dark" name="type">
                                <option class="">дні</option>
                                <option class="">год.</option>
                            </select>
                        </div>
                        <label for="tags" class="mt-2">Категорії</label>
                        <div>
                            <select id="type" class="form-control text-white border-0 bg-deep-dark">
                                <option value="0" disabled selected>(Виберіть тему замовлення)</option>
                                @foreach($categories as $select)
                                    <option class="" value="{{ $select->id_category }}">{{ $select->name }}</option>
                                @endforeach
                            </select>
                            <div style="display: none">
                                <input type="text" name="categories">
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <div class="" id="themes_block"></div>
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                            <button class="btn badge-pill text-white font-weight-bold bg-green">Створити замовлення</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-10 offset-1 text-white">
            <div class="font-size-20">Пошук за категоріями:</div>
            <div>
                @foreach($categories as $tags)
                <button class="btn text-white border-white categories_tag" data-id="{{ $tags->id_category }}">
                    <span class="font-weight-bold">{{ $tags->name }}</span>
                </button>
                @endforeach
            </div>
            <div class="d-flex justify-content-end input-group{{ count($data) ? ' ' : ' d-none' }}" id="drop-filter">
                <div class="">
                    <button class="btn sort-btn sort-selected text-white" id="date-btn">Датою <span class="badge badge-dark badge-pill">v</span></button>
                    <button class="btn sort-btn text-white" id="price-btn">Ціною <span class="badge badge-dark badge-pill"></span></button>
                </div>
            </div>
            @if($data !=[])
                <div class="container-fluid">
                    <div class="orders-list mt-2 mb-4" id="orders-list">
                        @foreach($data as $orders)
                            <div class="container-fluid shadow-box mb-4 work-order" data-id="{{ $orders->id_order }}">
                                <div class="d-flex flex-row justify-content-between align-items-center">
                                    <div class="d-flex justify-content-start">
                                        <div class="d-flex flex-row">
                                            <div class="font-weight-bold order-title font-size-30">{{ $orders->title }}</div>
                                            <div class="align-self-center ml-4">
                                                @if(!($orders->files) == 0)
                                                <img src="{{ asset('/edit.svg') }}" alt="edit" width="20px" id="edit">
                                                @endif
                                            </div>
                                            <div class="align-self-center ml-1">
                                                @if(!($orders->time) == 0)
                                                <img src="{{ asset('/calendar.svg') }}" alt="calendar" width="20px" id="calendar">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center font-weight-bold font-size-30 nowrap justify-content-end">{{ $orders->price }}</div>
                                </div>
                                <div class="text-gray">{{ $orders->created_at }}</div>
                                <div class="font-size-22">{{ mb_strlen($orders->description) > 200 ? mb_substr($orders->description, 0, 200) . '...' : $orders->description }}</div>
                                <div class="d-flex flex-row justify-content-between">
                                    <div class="d-flex justify-content-start align-items-center">
                                        <div class="tag-list">
                                            @foreach($orders->categories as $tags)
                                                <button class="btn border-gray">
                                                    <span class="text-gray">{{ $tags->name }}</span>
                                                </button>
                                            @endforeach
                                        </div>
                                        @if(!is_null($orders->dept))
                                            <div class="text-left float-left text-gray font-size-20 ml-2">{{ $orders->dept->name }}</div>
                                        @endif
                                    </div>
                                    <div class="d-flex flex-column justify-content-end">
                                        <button class="btn work-order bg-orange" data-id="{{ $orders->id_order }}">Переглянути</button>
                                        <form method="POST" action="{{ route('new_contact') }}" id="form-id" class=" text-center">
                                            @csrf
                                            <input type="text" name="id_user" class="d-none" value="{{ $orders->id_customer }}">
                                            @if($orders->id_customer != Auth::id())
                                            <span class="pointer font-size-12 text-gray" onclick="getElementById('form-id').submit();">Зв'язатися</span>
                                            @endif
                                        </form>
                                    </div>
                                </div>
                                <hr class="border-gray pb-4">
                            </div>
                        @endforeach
                    </div>
                    <div id="pagination" class="flex-row justify-content-center mb-3 {{ ceil($info['count'] / 10) < 2 ? 'd-none' : 'd-flex' }}">
                        <button class="btn btn-outline-p" disabled><<</button>&nbsp;
                        <button class="btn btn-outline-p" disabled><</button>&nbsp;
                        <button class="pagination-num pagination-selected btn btn-outline-p active" id="num-1" >1</button>&nbsp;
                        @for($i = 2; $i <= ceil($info['count'] / 10); $i++)
                            <button class="pagination-num btn btn-outline-p" id="num-{{ $i }}">{{ $i }}</button>&nbsp;
                        @endfor
                        <button class="btn btn-outline-p">></button>&nbsp;
                        <button class="btn btn-outline-p">>></button>
                    </div>
                @else
                    <div class="container orders" id="orders-list">
                        <div class="flex-row">
                            <div class="col font-weight-bold font-size-18 text-center mt-4">Немає залишених замовленнь</div>
                            <div class="d-flex justify-content-end text-center">
                            </div>
                        </div>
                    </div>
                    <div id="pagination" class="mb-3"></div>
                </div>
            @endif
        </div>
    </div>
</div>

<div class="flash-message fixed-bottom text-center">
    @foreach (['danger', 'warning', 'success', 'info'] as $msg)
        @if(Session::has('alert-' . $msg))
            <p class="alert alert-{{ $msg }} alert-dismissible"> {{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
        @endif
    @endforeach
</div>

@endsection

@section('footer')
    @include('site.footer')
@endsection
