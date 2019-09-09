@extends('layouts.site')

@section('header')
    @include('site.header')
@endsection

@section('content')

@php($data = $info['data'])
@php($sort = $info['sort'])
@php($categories = $info['categories'])

<div class="container" xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div class="row">
        <div class="col-8">
            <div class="container">
                <div class="row">
                    <div class="col-3 font-weight-bold text-left font-size-18">Всі проекти</div>
                    <div class="col-7 offset-2">
                        <form method="POST" action="{{route('save_order')}}" id="sort_form">
                            @csrf
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="col-form-label">Фільтрувати за:</span>
                                </div>
                                <div>
                                    <input style="display: none" name="prev_filter">
                                    <button name={{strpos($sort, 'id_order') !== false ? $sort : "id_order-asc"}} class="btn">Датою <span class="badge badge-primary badge-pill">{{ strpos($sort, 'id_order') !== false ? (strpos($sort, 'asc') !== false ? "^" : "v") : "" }}</span></button>
                                    <button name={{strpos($sort, 'price') !== false ? $sort : "price-asc"}} class="btn">Ціною <span class="badge badge-primary badge-pill">{{ strpos($sort, 'price') !== false ? (strpos($sort, 'asc') !== false ? "^" : "v") : "" }}</span></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @if(is_null(Auth::user()))
            @elseif(Auth::user()->id_role == 2)
                <div class="container pointer">
                    <div class="d-flex flex-row mb-3 mt-2" id="new_order-toggle" data-toggle="collapse" data-target="#new-order" aria-expanded="true">
                        <div class="col-11 pt-3 shadow-lg order_div">Створити власний проект</div>
                        <div class="col-1">
                            <div class="circle text-center text-white font-weight-bold bg-blue square-60 circle min-width-60 order_circle">&#43;</div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="container collapse" id="new-order">
                <div class="d-flex flex-row">
                    <form class="col" method="POST" action="{{route('save_order')}}">
                        @csrf
                        <div class="form-group row">
                            <label for="title" class="col-2 col-form-label mt-2">Назва:</label>
                            <div class="col-5 mt-2">
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="type" class="col-2 col-form-label mt-2">Тема:</label>
                            <div class="col-5 mt-2">
                                <select id="type" class="form-control">
                                    <option value="1" disabled selected>(Виберіть тему замовлення)</option>
                                    @foreach($categories as $select)
                                        <option value="{{$select->id_category}}">{{$select->name}}</option>
                                    @endforeach
                                </select>
                                <div style="display: none">
                                    <input type="text" name="categories">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-7" id="themes_block"></div>
                        </div>
                        <div class="form-group row">
                            <label for="price" class="col-2 col-form-label">Ціна:</label>
                            <div class="col-5 mt-2">
                                <input type="number" id="price" class="form-control" min="0" name="price">
                            </div>
                            <select class="col-2 mt-2 px-0 form-control" name="currency">
                                <option>грн.</option>
                                <option>$</option>
                            </select>
                        </div>
                        <div class="form-group row">
                            <label for="time" class="col-2 col-form-label">Час:</label>
                            <div class="col-5">
                                <input type="number" id="time" class="form-control" min="0" name="time">
                            </div>
                            <select class="col-2 px-0 form-control" name="type">
                                <option>дні</option>
                                <option>год.</option>
                            </select>
                        </div>
                        <div class="form-group row">
                            <label for="description" class="col-2 col-form-label mt-2">Інормація:</label>
                            <div class="col-8 mt-2">
                                <textarea class="form-control" name="description" id="description" rows="3" required></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <button type="submit" class="col-2 offset-8 text-white btn badge-pill bg-deep-blue mb-2 px-0" name="add_order">Підтвердити</button>
                            <button type="reset" class="col-2 btn badge-pill mb-2 px-0">Видалити</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="container orders">
                @foreach($data as $orders)
                    <div class="flex-row mb-3 mt-2 d-none">
                        <div class="col-10 shadow bg-white work-order pointer" data-id="{{$orders->id_order}}">
                            <div class="font-weight-bold mt-2 order-title">{{$orders->title}}</div>
                            <div class="tag-list">
                                @foreach($orders->categories as $tags)
                                    <span class="tags font-italic font-size-10">{{$tags->name}}</span>
                                @endforeach
                            </div>
                            <div>{{strlen($orders->description) > 50 ? substr($orders->description, 0, 50) . '...' : $orders->description}}</div>
                            <div class="text-right font-size-10">{{$orders->created_at}}</div>
                        </div>
                        <div class="col c_rounded-right mt-3 bg-green text-white px-0 align-self-end" style="height: 54px; !important;">
                            <div class="text-center font-weight-bold mt-1">{{$orders->price}}</div>
                            <div class="text-right font-italic font-size-10 mt-2 pr-2">{{$orders->time}}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="col-3 offset-1">
            <div class="card text-center px-0 mb-4">
                <div class="card-header text-white font-weight-bold font-size-18 c_rounded-top bg-blue">Пошук</div>
                <div class="card-body">
                    <input type="text" class="form-control" id="filter" value={{$info['filter']}}>
                </div>
            </div>
            <div class="card px-0">
                <div class="card-header text-center text-white font-weight-bold font-size-18 bg-blue">Всі категорії</div>
                <div class="card-body">
                    @foreach($categories as $tags)
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item py-0">
                                <a class="categories_tag" href="">{{$tags->name}} ({{$tags->count}})</a>
                            </li>
                        </ul>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>



@endsection

@section('footer')
    @include('site.footer')
@endsection
