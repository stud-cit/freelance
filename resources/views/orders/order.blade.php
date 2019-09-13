@extends('layouts.site')

@section('header')
    @include('site.header')
@endsection

@section('content')

@php($order = $data['order'])
@php($customer = $data['customer'])
@php($proposals = $data['proposals'])
@php($my_proposal = $data['my_proposal'])
@php($categories = $data['categories'])
@php($themes = $data['themes'])

<div class="container" xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div class="row">
        <div class="col-9">
            <a href= "{{ route('orders') }}" class="btn font-weight-bold font-size-18">&#10094; Пошук</a>
        </div>
        <div class="col-9 text-white c_rounded bg-blue">
                <div class="row mt-4">
                    <div class="col-3 offset-1 font-weight-bold font-size-18">{{$order->title}}</div>
                    <div class="col-1 offset-5 font-size-10 mt-2">Ціна:</div>
                    <div class="col-2 font-weight-bold font-size-18">{{$order->price}}</div>
                </div>
            <div class="row">
                <div class="col-1 offset-9 font-size-10 mt-2">Час:</div>
                <div class="col-2 font-weight-bold font-size-18">{{$order->time}}</div>
            </div>
            <div class="offset-1">
                @foreach($categories as $tags)
                    <span class="tags font-italic font-size-10">{{$tags->name}}</span>
                @endforeach
                <div class="mt-4 font-size-10">{{$order->description}}</div>
                <div class="mt-4 font-size-10">Дата створення: {{$order->created_at}}</div>
            </div>
            @if(Auth::user()->isWorker() && $order->status == 'new')
                <button class="btn badge-pill text-white bg-deep-blue px-0 col-3 offset-8 mt-4 mb-2 propose-toggle"  data-toggle="collapse" data-target="#prop" aria-expanded="true">
                    {{is_null($my_proposal) ? 'Видвинути пропозицію' : 'Змінити пропозицію'}}
                </button>
            @elseif(Auth::user()->id == $order->id_customer && $order->status == 'new')
                <div class="row">
                    <button class="btn badge-pill text-white bg-deep-blue px-0 col-3 offset-5 mt-4 mb-2" data-toggle="collapse" data-target="#edit-order" aria-expanded="false">
                        Змінити замовлення
                    </button>
                    <form method="POST" action="{{ route('delete_order', $order->id_order) }}" class="col-3">
                        @csrf
                        <button class="btn badge-pill text-white bg-danger px-0 mt-4 mb-2 w-100">
                            Видалити замовлення
                        </button>
                    </form>
                </div>
            @elseif($order->status == 'in progress' && Auth::user()->id == $order->id_customer)
                <button class="propose-toggle btn badge-pill text-white bg-deep-blue px-0 col-3 offset-5 mt-4 mb-2" name="ok_worker">
                    Замовлення виконано
                </button>
                <button type="submit" class="propose-toggle btn btn-danger badge-pill text-white px-0 col-3 mt-4 mb-2" name="cancel_worker">
                    Змінити виконавця
                </button>
            @endif
        </div>
        <div class="col-3 text-white text-center c_rounded-right mt-4 mb-2 bg-deep-blue">
            <div class="mt-2 to-profile pointer" data-id="{{$order->id_customer}}">
                <img src="{{$customer->avatar}}" class="square-100 avatar circle">
            </div>
            <div class="container text-left">
                <div class="row mb-2">
                    <div class="col-11 offset-1 font-weight-bold mt-1">{{$customer->name}} {{$customer->surname}}</div>
                    <div class="col-11 offset-1 font-size-10">E-mail: {{$customer->email}}</div>
                    <div class="col-11 offset-1 font-size-10">Phone number: {{$customer->phone_number}}</div>
                    <div class="col-11 offset-1 font-size-10">Viber: {{$customer->viber}}</div>
                    <div class="col-11 offset-1 font-size-10">Skype: {{$customer->skype}}</div>
                </div>
            </div>
        </div>
        <div class="col-8 mt-4 px-0">
            @if(Auth::user()->isWorker() && $order->status == 'new')
                <div id="prop" class="collapse">
                    <p class="font-size-18 font-weight-bold">{{is_null($my_proposal) ? 'Видвинути пропозицію' : 'Змінити пропозицію'}}</p>
                    <form method="POST" action="{{ route('add_proposal', $order->id_order) }}" class="col mt-2 bg-white shadow c_rounded">
                        @csrf
                        <div class="form-group row">
                            <label for="price" class="col-sm-2 col-form-label mt-2">Ціна:</label>
                            <div class="col-sm-3 mt-2">
                                <input type="number" id="price" class="form-control" min="0" name="price" value="{{!is_null($my_proposal) ? $my_proposal->price : ''}}">
                            </div>
                            <select class="col-sm-1 mt-2 px-0 form-control" name="currency">
                                <option {{!is_null($my_proposal) ? ($my_proposal->currency == 'грн.' ? 'selected' : '') : ''}}>грн.</option>
                                <option {{!is_null($my_proposal) ? ($my_proposal->currency == '$' ? 'selected' : '') : ''}}>$</option>
                            </select>
                        </div>
                        <div class="form-group row">
                            <label for="time" class="col-sm-2 col-form-label">Час:</label>
                            <div class="col-sm-3">
                                <input type="number" id="time" class="form-control" min="0" name="time" value="{{!is_null($my_proposal) ? $my_proposal->time : ''}}">
                            </div>
                            <select class="col-sm-1 px-0 form-control" name="type">
                                <option {{!is_null($my_proposal) ? ($my_proposal->type != 'год.' ? 'selected' : '') : ''}}>дні</option>
                                <option {{!is_null($my_proposal) ? ($my_proposal->type == 'год.' ? 'selected' : '') : ''}}>год.</option>
                            </select>
                        </div>
                        <div class="form-group row">
                            <label for="comment" class="col-sm-2 col-form-label">Коментар:</label>
                            <div class="col-sm-10">
                                <textarea id="comment" class="form-control" rows="3" name="text" required>{{!is_null($my_proposal) ? $my_proposal->text : ''}}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <button type="submit" class="col-lg-2 col-3 offset-lg-8 offset-5 text-white btn badge-pill bg-deep-blue mb-2 px-0" name="form_proposals">Підтвердити</button>
                            <button class="col-lg-2 col-3 offset-lg-0 offset-5 btn badge-pill mb-2 px-0" name="delete_proposal">Видалити</button>
                        </div>
                    </form>
                </div>
            @elseif($order->status == 'in progress' && Auth::user()->id == $order->id_customer)
                <div id="prop" style="display: none;">
                    <p class="font-size-18 font-weight-bold">Залишити відгук</p>
                    <form method="POST" action="{{ route('add_review', $order->id_order) }}" class="col bg-white shadow c_rounded">
                        @csrf
                        <input name="cancel_check" style="display: none">
                        <div class="form-group row">
                            <p class="col-2 mt-3">Без відгуку:</p>
                            <div class="col-3 mt-3">
                                <input type="checkbox" id="" class="form-check-input disable-comment">
                            </div>
                        </div>
                        <div class="form-group row">
                            <p class="col-2">Оцінка:</p>
                            <div class="col-3 rating">
                                <input type="range" id="rating" class="reviews-rating" name="rating" min="1" max="5" step="0.5" value="3">
                            </div>
                            <div class="">
                                <span id="rating_val">3</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="comment" class="col-1 col-form-label">Коментар:</label>
                            <div class="col offset-1">
                                <textarea id="comment" class="form-control reviews-comment" rows="3" name="text" required></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <button type="submit" class="col-3 offset-8 text-white btn badge-pill bg-deep-blue mb-2 px-0" name="leave_review">Підтвердити</button>
                        </div>
                    </form>
                </div>
            @endif
            @if(Auth::user()->id == $order->id_customer && $order->status == 'new')
                <div class="container collapse" id="edit-order">
                    <div class="d-flex flex-row">
                        <form class="col bg-white shadow" method="POST" action="{{route('edit_order', $order->id_order)}}">
                            @csrf
                            <div class="form-group row">
                                <label for="title" class="col-2 col-form-label mt-2">Назва:</label>
                                <div class="col-5 mt-2">
                                    <input type="text" class="form-control" id="title" name="title" value="{{ $order->title }}" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="type" class="col-2 col-form-label mt-2">Тема:</label>
                                <div class="col-5 mt-2">
                                    <select name="type" id="type" class="form-control">
                                        <option value="0" disabled selected>(Виберіть тему замовлення)</option>
                                        @foreach($themes as $select)
                                            <option value="{{$select->id_category}}">{{$select->name}}</option>
                                        @endforeach
                                    </select>
                                    <div style="display: none">
                                        <input type="text" name="categories" value="{{$data['string']}}">
                                    </div>
                                    <div class="form-group row">
                                        <div class="" id="themes_block"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-7" id="themes_block"></div>
                            </div>
                            <div class="form-group row">
                                <label for="price" class="col-2 col-form-label">Ціна:</label>
                                <div class="col-5 mt-2">
                                    <input type="number" id="price" class="form-control" min="0" name="price" value="{{ explode(" " , $order->price)[0] }}">
                                </div>
                                <select class="col-2 mt-2 px-0 form-control" name="currency">
                                    <option {{ !is_null($order->price) && explode(" ", $order->price)[1] == "грн." ? "selected" : ""}}>грн.</option>
                                    <option {{ !is_null($order->price) && explode(" ", $order->price)[1] == "$" ? "selected" : ""}}>$</option>
                                </select>
                            </div>
                            <div class="form-group row">
                                <label for="time" class="col-2 col-form-label">Час:</label>
                                <div class="col-5">
                                    <input type="number" id="time" class="form-control" min="0" name="time" value="{{ explode(" ", $order->time)[0] }}">
                                </div>
                                <select class="col-2 px-0 form-control" name="type">
                                    <option {{ !is_null($order->time) && explode(" ", $order->time)[1] == "дні" ? "selected" : ""}}>дні</option>
                                    <option {{ !is_null($order->time) && explode(" ", $order->time)[1] == "год." ? "selected" : ""}}>год.</option>
                                </select>
                            </div>
                            <div class="form-group row">
                                <label for="description" class="col-2 col-form-label mt-2">Інормація:</label>
                                <div class="col-8 mt-2">
                                    <textarea class="form-control" name="description" id="description" rows="3" required>{{ $order->description }}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <button type="submit" class="col-2 offset-8 text-white btn badge-pill bg-deep-blue mb-2 px-0" name="edit_order">Підтвердити</button>
                                <button type="reset" class="col-2 btn badge-pill mb-2 px-0">Скинути</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
            <div class="col">
                <div class="container proposals">
                    @if(count($proposals) != 0)
                        <div class="font-weight-bold font-size-18 mt-4">Пропозиції виконавців</div>
                    @foreach($proposals as $comment)
                        <div class="d-flex flex-row mb-3 mt-2 pointer">
                            <div class="col-1 px-0 min-width-70 to-profile" data-id="{{$comment->id_user}}">
                                <img src="{{$comment->avatar}}" class="mt-1 square-60 avatar square">
                            </div>
                            <div class="col-9 shadow bg-white" data-id="{{$comment->id_user}}">
                                <div class="flex-row" @if(Auth::user()->isCustomer()) data-toggle="collapse" data-target="#w-id-{{ $comment->id_user }}" aria-expanded="true"@endif>
                                    <div class="font-weight-bold mt-2"><span class="to-profile" data-id="{{$comment->id_user}}">{{$comment->name}} {{$comment->surname}}</span></div>
                                    <div class="">{{$comment->text}}</div>
                                    <div class="text-right font-size-10">{{$comment->created_at}}</div>
                                </div>
                                @if(Auth::user()->id == $order->id_customer && $order->status == 'new')
                                    <form method="POST" action="{{route('select_worker', $order->id_order)}}" class="col c_rounded select_worker">
                                        @csrf
                                        <div class="collapse" id="w-id-{{ $comment->id_user }}" aria-expanded="false">
                                            <button type="submit" class="col-lg-3 col-6 offset-lg-8 offset-5 text-white btn badge-pill bg-deep-blue mb-2 px-0" name="selected_worker" value="{{$comment->id_user}}">Підтвердити</button>
                                        </div>
                                    </form>
                                @endif
                            </div>
                            <div class="col c_rounded-right bg-green text-white mt-3 align-self-end" style="height: 54px; !important;">
                                <div class="text-center font-weight-bold mt-1">{{$comment->price}}&nbsp;</div>
                                <div class="text-right font-italic font-size-10 mt-2">{{$comment->time}}&nbsp;</div>
                            </div>
                        </div>
                    @endforeach
                    @elseif(count($proposals) == 0)
                        <div class="font-weight-bold font-size-18 mb-4 mt-4">Немає залишених пропозицій</div>
                    @endif
                </div>
            </div>
        </div>
{{--        <div class="col-3 offset-1 px-0 mt-4">--}}
{{--            <div class="card">--}}
{{--                <div class="card-header text-left font-weight-bold font-size-18">Схожі заяви</div>--}}
{{--                <div class="card-body"> dooot </div>--}}
{{--            </div>--}}
{{--        </div>--}}
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
