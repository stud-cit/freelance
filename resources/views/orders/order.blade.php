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
@php($dept = $data['dept'])

<div class="container-fluid w-100 bg-orange">
    <div class="container">
        <div class="row d-flex align-items-center">
            <div class="col-md-1 col-2">
                <a href= "{{ route('orders') }}" class="btn font-weight-bold text-white font-size-18"><img src="{{ asset("/left_arrow.svg") }}" alt="Назад" height="29px" class="align-self-center"></a>
            </div>
            <div class="col-md-8 col-6 border-right border-grey">
                <div class="font-weight-bold text-white font-size-18">{{ $order->title }}</div>
            </div>
            <div class="col-3">
                <div class="font-weight-bold text-white font-size-18">
                    @if(!is_null($order->price))
                        {{ $order->price }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid mt-4">
    <div class="container text-white">
    <div class="row">
        <div class="col-md-5 col-12">
            <div class="font-weight-bold font-size-20">Опис замовлення</div>
            <div>
                <div>{{ $order->description }}</div>
            </div>
            @if($order->files)
                <hr class="w-100 border-grey">
                <div>
                    <form action="{{ route('get_files', $order->id_order) }}" method="POST" id="get-files">
                        @csrf
                        <input type="text" class="d-none" value="{{ $order->title . '.zip' }}" name="name">
                        <span onclick="getElementById('get-files').submit();" class="pointer btn btn-outline-light">&#128190;&nbsp;Завантажити прікріплені файли</span>
                    </form>
                </div>
                @if(Auth::check() && $order->id_customer == Auth::id())
                    <div>
                        <form action="{{ route('delete_file', $order->id_order) }}" method="POST" id="delete-files">
                            @csrf
                            <span onclick="getElementById('delete-files').submit();" class="pointer btn btn-outline-light">Х Видалити прікріплені файли</span>
                        </form>
                    </div>
                @endif
            @endif
        </div>
        <div class="col-md-1 d-md-flex d-none"><div class="border-right border-grey h-100">&nbsp;</div></div>
        <div class="col-md-5 col-12">
            <div class="d-flex flex-column align-items-center">
                <div>Категорії</div>
                <div class="d-flex flex-row">
                    <div>
                        @foreach($categories as $tags)
                            <span class="btn text-white border-white" data-id="{{ $tags->id_category }}">
                                <span>{{ $tags->name }}</span>
                            </span>
                        @endforeach
                    </div>
                </div>
                <hr class="w-100 border-grey">
                <div>Строки виконання</div>
                <div><span class="font-weight-bold">{{ $order->time }}</span></div>
                <hr class="w-100 border-grey">
                <div class="row">
                    <div class="col-3 to-profile pointer" data-id="{{ $order->id_customer }}">
                        <img src="{{ $customer->avatar }}" class="square-54 avatar circle justify-content-end">
                    </div>
                    <div class="col-9">
                        <div class="text-center">
                            <div class="font-weight-bold mt-1 nowrap">{{ $customer->name }} {{ $customer->surname }}</div>
                            @if(!is_null($dept))
                                <div class="text-center">{{ $dept->name }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <hr class="border-0">
                <div>
                    <form method="POST" action="{{ route('new_contact') }}" id="form-id" class=" text-center">
                        @csrf
                        <input type="text" name="id_user" class="d-none" value="{{ $order->id_customer }}">
                        @if(Auth::check() && $order->id_customer != Auth::id())
                            <button class="btn bg-blue rounded-pill text-white">Зв'язатися</button>
                        @endif
                    </form>
                    @if(Auth::check() && Auth::id() == $order->id_customer && $order->status == 'new' && !Auth::user()->banned)
                        <button  class="btn badge-pill border-white text-white mb-2 w-100" data-toggle="collapse" data-target="#edit-order" aria-expanded="false">Змінити замовлення</button>
                    @elseif(Auth::check() && $order->status == 'in progress' && Auth::id() == $order->id_customer && !Auth::user()->banned)
                        <div class="row mt-4">
                            <div class="col-xl-6 col-12">
                                <form method="POST" action="{{ route('finish_order', $order->id_order) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-outline badge-pill border-white text-white mb-2 w-100" id="finish_order">
                                        Замовлення виконано
                                    </button>
                                </form>
                            </div>
                            <div class="col-xl-6 col-12">
                                <button class="btn badge-pill text-white bg-orange px-0 mb-2 w-100" data-toggle="collapse" data-target="#accepted_order" aria-expanded="false">
                                    Змінити виконавця
                                </button>
                            </div>
                        </div>
                    @elseif(!Auth::check())
                        <a href="{{ route('register') }}" class="btn badge-pill bg-orange text-white">Зареєструватися</a>
                    @endif
                </div>
            </div>
        </div>
        </div>
        <div class="d-flex flex-row justify-content-center">
            <div class="col-12 text-center">
                @if(Auth::check() && Auth::user()->isWorker() && $order->status == 'new' && (is_null($my_proposal) || !$my_proposal->blocked) && !Auth::user()->banned)
                    <button class="btn text-white" data-toggle="collapse" data-target="#prop" aria-expanded="true">
                        &#8595;&nbsp;{{ is_null($my_proposal) ? 'Залишити пропозицію' : 'Змінити пропозицію' }}&nbsp;&#8595;
                    </button>
                @endif
            </div>
        </div>
    </div>
        <div class="row">
            <div class="col-12 bg-light-grey text-white my-4 shadow-lg">
                @if(Auth::check() && Auth::user()->isWorker() && $order->status == 'new' && (is_null($my_proposal) || !$my_proposal->blocked) && !Auth::user()->banned)
                <div id="prop" class="collapse container shadow-box py-4">
                    <form method="POST" action="{{ route('add_proposal', $order->id_order) }}" class="col mt-2shadow c_rounded">
                        @csrf
                        <div class="row">
                            <div class="col-md-5 col-12 offset-md-1 form-group">
                                <label for="comment" class="">Опис пропозиції:</label>
                                <textarea id="comment" class="form-control text-white border-0 bg-deep-dark" rows="6" name="text">{{ !is_null($my_proposal) ? $my_proposal->text : 'Згоден' }}</textarea>
                            </div>
                            <div class="col-md-5 col-12 form-group">
                                <label for="price">Ціна:</label>
                                <div class="d-flex flex-row">
                                    <input type="number" id="price" class="col-md-9 col-8 form-control text-white border-0 bg-deep-dark" min="0" name="price" value="{{ !is_null($my_proposal) ? $my_proposal->price : (!is_null($order->price) ? explode(' ', $order->price)[0] : '') }}">
                                    <select class="col-md-2 offset-md-1 col-3 offset-1 form-control text-white border-0 bg-deep-dark" name="currency">
                                        <option {{ !is_null($my_proposal) ? ($my_proposal->currency == 'грн.' ? 'selected' : '') : (!is_null($order->price) && explode(' ', $order->price)[1] =='грн.' ? 'selected' : '') }}>грн.</option>
                                        <option {{ !is_null($my_proposal) ? ($my_proposal->currency == '$' ? 'selected' : '') : (!is_null($order->price) && explode(' ', $order->price)[1] =='$' ? 'selected' : '') }}>$</option>
                                    </select>
                                </div>
                                <label for="time" class="mt-2">Час:</label>
                                <div class="d-flex flex-row">
                                    <input type="number" id="time" class="col-md-9 col-8 form-control text-white border-0 bg-deep-dark" min="0" name="time" value="{{ !is_null($my_proposal) ? $my_proposal->time : (!is_null($order->time) ? explode(' ', $order->time)[0] : '') }}">
                                    <select class="col-md-2 offset-md-1 col-3 offset-1 form-control text-white border-0 bg-deep-dark" name="type">
                                        <option {{ !is_null($my_proposal) ? ($my_proposal->type != 'год.' ? 'selected' : '') : (!is_null($order->time) && explode(' ', $order->time)[1] !='год.' ? 'selected' : '') }}>дні</option>
                                        <option {{ !is_null($my_proposal) ? ($my_proposal->type == 'год.' ? 'selected' : '') : (!is_null($order->time) && explode(' ', $order->time)[1] =='год.' ? 'selected' : '') }}>год.</option>
                                    </select>
                                </div>
                                <div class="d-flex row justify-content-center mt-4">
                                    <button type="submit" class="col-md-5 col-10 text-white btn badge-pill bg-green mb-2 px-0" name="form_proposals">Підтвердити</button>
                                    <button {{ is_null($my_proposal) ? 'type=reset' : '' }} class="col-md-5 col-10 btn badge-pill border-grey text-white mb-2 px-0" name="delete_proposal">{{is_null($my_proposal) ? 'Скинути' : 'Видалити'}}</button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                @endif
                @if(Auth::check() && Auth::id() == $order->id_customer && $order->status == 'new' && !Auth::user()->banned)
                <div class="container collapse py-4" id="edit-order">
                    <div class="d-flex flex-row">
                        <form method="POST" action="{{ route('edit_order', $order->id_order) }}" enctype="multipart/form-data" class="col-12">
                            @csrf
                            <div class="d-flex row justify-content-around">
                                <div class="form-group col-md-6 col-12">
                                    <label for="title">Назва</label>
                                    <input type="text" class="form-control text-white border-0 bg-deep-dark" id="title" name="title" value="{{ $order->title }}" required>
                                    <label for="description" class="mt-2">Інформація</label>
                                    <textarea class="form-control text-white border-0 bg-deep-dark" name="description" id="description" rows="5" required>{{ $order->description }}</textarea>
                                    <div>Нові файли</div>
                                    <input id="add-files" type="file" class="col-11 btn badge-pill bg-white mt-2" multiple="multiple" name="files[]">
                                </div>
                                <div class="form-group col-md-6 col-12">
                                    <label for="price">Ціна</label>
                                    <div class="d-flex flex-row">
                                        <input type="number" class="col-md-9 col-8 form-control text-white border-0 bg-deep-dark" id="price" name="price" value="{{ explode(" " , $order->price)[0] }}">
                                        <select class="col-md-2 offset-md-1 col-3 offset-1 form-control text-white border-0 bg-deep-dark" name="currency">
                                            <option {{ !is_null($order->price) && explode(" ", $order->price)[1] == "грн." ? "selected" : ""}}>грн.</option>
                                            <option {{ !is_null($order->price) && explode(" ", $order->price)[1] == "$" ? "selected" : ""}}>$</option>
                                        </select>
                                    </div>
                                    <label for="time" class="mt-2">Час</label>
                                    <div class="d-flex flex-row">
                                        <input type="number" class="col-md-9 col-8 form-control text-white border-0 bg-deep-dark" id="time" name="time" value="{{ explode(" ", $order->time)[0] }}">
                                        <select class="col-md-2 offset-md-1 col-3 offset-1 form-control text-white border-0 bg-deep-dark" name="type">
                                            <option {{ !is_null($order->time) && explode(" ", $order->time)[1] == "дні" ? "selected" : ""}}>дні</option>
                                            <option {{ !is_null($order->time) && explode(" ", $order->time)[1] == "год." ? "selected" : ""}}>год.</option>
                                        </select>
                                    </div>
                                    <label for="tags" class="mt-2">Категорії</label>
                                    <div>
                                        <select id="type" class="form-control text-white border-0 bg-deep-dark">
                                            <option value="0" disabled selected>(Виберіть тему замовлення)</option>
                                            @foreach($themes as $select)
                                                <option value="{{ $select->id_category }}">{{ $select->name }}</option>
                                            @endforeach
                                        </select>
                                        <div style="display: none">
                                            <input type="text" name="categories" value="{{ $data['string'] }}">
                                        </div>
                                        <div class="form-group row">
                                            <div id="themes_block"></div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-2">
                                        <div id="themes_block"></div>
                                    </div>
                                    <div class="d-flex justify-content-center mt-4">
                                        <button class="col-md-4 col-10  btn badge-pill text-white bg-green">Підтвердити</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @endif
            </div>
        </div>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="proposals text-white">
                    @if(count($proposals) != 0)
                        @if(Auth::user()->id_role == 2)
                        <div class="font-weight-bold font-size-18 mt-4">Пропозиції виконавців</div>
                        @else
                        <div class="font-weight-bold font-size-18 mt-4">Моя пропозиція</div>
                        @endif
                        @foreach($proposals as $comment)
                            <div class="d-flex flex-column mb-3 mt-2 shadow-lg p-2">
                                <div class="d-flex flex-row align-items-center">
                                    <div class="min-width-70 pointer to-profile" data-id="{{ $comment->id_user }}">
                                        <img src="{{ $comment->avatar }}" class="square-54 circle avatar">
                                    </div>
                                    <div @if(Auth::check() && Auth::id() == $order->id_customer && !Auth::user()->banned)@endif>
                                        <div class="font-weight-bold"><span class="to-profile pointer" data-id="{{ $comment->id_user }}">{{ $comment->name }} {{ $comment->surname }}</span></div>
                                    </div>
                                    @if(Auth::check() && Auth::id() == $order->id_customer && $order->status == 'new' && !Auth::user()->banned)
                                        <form method="POST" action="{{ route('select_worker', $order->id_order) }}" class="col select_worker">
                                            @csrf
                                            <div id="w-id-{{ $comment->id_user }}" aria-expanded="false">
                                                <button type="submit" class="col-md-3 col-12 text-white btn rounded bg-green float-right" name="selected_worker" value="{{$comment->id_user}}">Підтвердити</button>
                                            </div>
                                        </form>
                                    @endif
                                </div>
                                <hr class="w-100 border-grey">
                                <div class="d-flex flex-row">
                                    <div class="flex-grow-1">{{ $comment->text }}</div>
                                    <div class="text-white text-center">
                                        <div class="font-weight-bold mt-1">{{ $comment->price }}&nbsp;</div>
                                        <div class="font-italic font-size-10 mt-2">{{ $comment->time }}&nbsp;</div>
                                    </div>
                                </div>
                                <div class="d-flex flex-row">
                                    <div class="text-grey font-size-10">{{ $comment->created_at }}</div>
                                </div>
                            </div>
                        @endforeach
                    @elseif(Auth::check() && Auth::user()->id_role == 2 && count($proposals) == 0)
                        <div class="font-weight-bold font-size-18 my-4 text-center">Немає залишених пропозицій</div>
                    @endif
                </div>
                {{ $proposals->links('layouts.pagination') }}
            </div>
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
