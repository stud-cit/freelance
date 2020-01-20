@extends('layouts.site')

@section('header')
    @include('site.header')
@endsection

@section('content')

@php($data = $info['data'])
@php($categories = $info['categories'])
@php($dept = $info['dept'])

<div class="d-none" id="my_id" data-id="{{ Auth::id() }}"></div>
<div class="container-fluid">
    <div class="row">
        <div class="col-10 offset-1 text-white">
            <div class="font-weight-bold font-size-40">Пошук по проектам</div>
        </div>
        <div class="col-11">
            <div class="d-flex flex-row">
                @if(!(Auth::check()) || Auth::user()->id_role != 2)
                    <div class="col-1"></div>
                @elseif(Auth::user()->id_role == 2)
                    <div class="col-1 d-flex justify-content-end">
                        <button class="btn circle text-white text-center font-weight-bold font-size-25 bg-green square-54 px-0 @if(Auth::user()->banned) 'd-none' @endif" id="new_order-toggle" data-toggle="collapse" data-target="#new-order" aria-expanded="true" title="Створення замовлення">&#43;</button>
                    </div>
                @endif
                <div class="input-group col-11 for-filter">
                    <input type="text" class="form-control" aria-label="filter" id="filter" style="height: 54px">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary bg-dark-green text-white dropdown-toggle font-size-25" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width: 250px">Кафедри</button>
                        <div class="dropdown-menu try" id="depts">
                            <ul class=" list-group">
                                <a class="categories_tag dropdown-item selected-category bg-white" href="" data-id="0">Всі</a>
                            </ul>
                            @foreach($dept as $item)
                                @foreach($item as $value)
                                    <a class="categories_tag dropdown-item bg-white type-{{$value->id_type}}" href=""data-id="{{ $value->id_dept }} ">{{ $value->name }}</a>
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container collapse bg-light-grey text-white my-2" id="new-order">
            <form method="POST" action="{{ route('save_order') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-6 mt-4">
                        <p class="font-size-35 font-weight-bold bg-orange text-center">Створення замовлення</p>
                    </div>
                </div>
                <div class="d-flex flex-row justify-content-around">
                    <div class="form-group col-5">
                        <label for="title" class="font-size-20">Назва*</label>
                        <input type="text" class="form-control text-white border-0 bg-deep-dark" id="title" name="title" required>
                        <label for="description" class="font-size-20 mt-2">Інформація*</label>
                        <textarea class="form-control text-white border-0 bg-deep-dark" name="description" id="description" rows="5" required></textarea>
                        <input id="add-files" type="file" class="btn badge-pill bg-white mt-2" multiple="multiple" name="files[]">
                    </div>
                    <div class="border-left"></div>
                    <div class="form-group col-5">
                        <label for="price" class="font-size-20">Ціна</label>
                        <div class="d-flex flex-row">
                            <input type="number" class="col-9 form-control text-white border-0 bg-deep-dark" id="price" name="price">
                            <select class="col-2 offset-1 form-control font-size-15 text-white border-0 bg-deep-dark" name="currency">
                                <option>грн.</option>
                                <option>$</option>
                            </select>
                        </div>
                        <label for="time" class="font-size-20 mt-2">Час</label>
                        <div class="d-flex flex-row">
                            <input type="number" class="col-9 form-control text-white border-0 bg-deep-dark" id="time" name="time">
                            <select class="col-2 offset-1 form-control font-size-15 text-white border-0 bg-deep-dark" name="type">
                                <option>дні</option>
                                <option>год.</option>
                            </select>
                        </div>
                        <label for="tags" class="font-size-20 mt-2">Категорії</label>
                        <div>
                            <select id="type" class="form-control font-size-15 text-white border-0 bg-deep-dark">
                                <option value="0" disabled selected>(Виберіть тему замовлення)</option>
                                @foreach($categories as $select)
                                    <option value="{{ $select->id_category }}">{{ $select->name }}</option>
                                @endforeach
                            </select>
                            <div style="display: none">
                                <input type="text" name="categories">
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <div id="themes_block"></div>
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                            <button class="btn badge-pill text-white font-size-20 bg-green">Створити замовлення</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-10 offset-1 text-white" id="orders-block">
            <div class="font-size-20">Пошук за категоріями:</div>
            <div class="for-filter" id="categs">
                <button class="btn mb-1 text-white border-white categories_tag selected-category" data-id="0">
                    <span>Всі</span>
                </button>
                @foreach($categories as $tags)
                    <button class="btn mb-1 text-white border-white categories_tag" data-id="{{ $tags->id_category }}">
                        <span>{{ $tags->name }}</span>
                    </button>
                @endforeach
            </div>
            <div class="d-flex justify-content-end input-group{{ count($data) ? ' ' : ' d-none' }}" id="drop-filter">
                <div>
                    <button class="btn sort-btn sort-selected text-white" id="date-btn">Датою <span class="badge badge-dark badge-pill">v</span></button>
                    <button class="btn sort-btn text-white" id="price-btn">Ціною <span class="badge badge-dark badge-pill"></span></button>
                </div>
            </div>

            @include('orders.filter')

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
