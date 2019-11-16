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
            <div class="col-1">
                <a href= "{{ route('orders') }}" class="btn font-weight-bold text-white font-size-18"><img src="{{ asset("/left_arrow.svg") }}" alt="Назад" height="29px" class="align-self-center"></a>
            </div>
            <div class="col-8 border-right border-grey">
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
    <!--
    <form action="{{ route('get_files', $order->id_order) }}" method="POST"class="bg-white" id="get-files">
        @csrf
        <input type="text" class="d-none" value="{{ $order->title . '.zip' }}" name="name">
        <span onclick="getElementById('get-files').submit();" class="pointer">Завантажити прікріплені файли</span>
    </form>
    -->
    <div class="container text-white">
    <div class="row">
        <div class="col-5">
            <div>Опис замовлення</div>
            <div>
                <div class="">{{ $order->description }}</div>
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
            @endif
        <!--
            <div class="row mt-4">
                <div class="col-8 offset-1 font-weight-bold font-size-18">{{ $order->title }}</div>
                <div class="col-3">
                    <div class="col font-weight-bold font-size-18">
                        @if(!is_null($order->price))
                            <span class="font-size-10">Ціна:</span>&nbsp;{{ $order->price }}
                        @endif
                    </div>
                    <div class="col font-weight-bold font-size-18">
                        @if(!is_null($order->time))
                            <span class="font-size-10">Час:</span>&nbsp;&nbsp;{{ $order->time }}
                        @endif
                    </div>
                </div>
            </div>
            <div class="offset-1">
                @foreach($categories as $tags)
                    <span class="tags font-italic font-size-10">{{ $tags->name }}</span>
                @endforeach
                <div class="mt-4 font-size-10">{{ $order->description }}</div>
                @if(!is_null($dept))
                    <div class="mt-4 font-size-10">{{ $dept->name }}</div>
                @endif
                <div class="mt-4 font-size-10">Дата створення: {{ $order->created_at }}</div>
            </div>
            @if(Auth::user()->isWorker() && $order->status == 'new' && (is_null($my_proposal) || !$my_proposal->blocked) && !Auth::user()->banned)
                <button class="btn badge-pill text-white bg-deep-blue px-0 col-xl-3 col-6 offset-xl-8 offset-6 mt-4 mb-2" data-toggle="collapse" data-target="#prop" aria-expanded="true">
                    {{ is_null($my_proposal) ? 'Залишити пропозицію' : 'Змінити пропозицію' }}
                </button>
            @elseif(Auth::id() == $order->id_customer && $order->status == 'new' && !Auth::user()->banned)
                <div class="row mt-4">
                    <div class="col-xl-3 col-6 offset-xl-5 offset-6">
                        <button class="btn badge-pill text-white bg-deep-blue mb-2 w-100" data-toggle="collapse" data-target="#edit-order" aria-expanded="false">
                            Змінити замовлення
                        </button>
                    </div>
                    <div class="col-xl-3 col-6 offset-xl-0 offset-6">
                        <form method="POST" action="{{ route('delete_order', $order->id_order) }}" onsubmit="return confirm('Ви впевнені?');">
                            @csrf
                            <button class="btn badge-pill text-white bg-danger px-0 mb-2 w-100">
                                Видалити замовлення
                            </button>
                        </form>
                    </div>
                </div>
            @elseif($order->status == 'in progress' && Auth::id() == $order->id_customer && !Auth::user()->banned)
                <div class="row mt-4">
                    <div class="col-xl-3 col-6 offset-xl-5 offset-6">
                        <form method="POST" action="{{ route('finish_order', $order->id_order) }}" onsubmit="return confirm('Ви впевнені?');">
                            @csrf
                            <button type="submit" class="btn badge-pill text-white bg-deep-blue mb-2 w-100">
                                Замовлення виконано
                            </button>
                        </form>
                    </div>
                    <div class="col-xl-3 col-6 offset-xl-0 offset-6">
                        <button class="btn badge-pill text-white bg-danger px-0 mb-2 w-100" data-toggle="collapse" data-target="#accepted_order" aria-expanded="false">
                            Змінити виконавця
                        </button>
                    </div>
                </div>
            @endif-->
        </div>
        <div class="col-1"><div class="border-right border-grey h-100">&nbsp;</div></div>
        <div class="col-5">
            <div class="d-flex flex-column align-items-center">
                <div>Категорії</div>
                <div class="d-flex flex-row">
                    <div>
                        @foreach($categories as $tags)
                            <button class="btn text-white border-white" data-id="{{ $tags->id_category }}">
                                <span>{{ $tags->name }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>
                <hr class="w-100 border-grey">
                <div>Строки</div>
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
                <div><button class="btn bg-blue rounded-pill text-white">Зв'язатися</button></div>
            </div><!--
            <div class="row mt-4">
                <div class="col-8 offset-1 font-weight-bold font-size-18">{{ $order->title }}</div>
                <div class="col-3">
                    <div class="col font-weight-bold font-size-18">
                        @if(!is_null($order->price))
                            <span class="font-size-10">Ціна:</span>&nbsp;{{ $order->price }}
                        @endif
                    </div>
                    <div class="col font-weight-bold font-size-18">
                        @if(!is_null($order->time))
                            <span class="font-size-10">Час:</span>&nbsp;&nbsp;{{ $order->time }}
                        @endif
                    </div>
                </div>
            </div>
            <div class="offset-1">
                @foreach($categories as $tags)
                    <span class="tags font-italic font-size-10">{{ $tags->name }}</span>
                @endforeach
                <div class="mt-4 font-size-10">{{ $order->description }}</div>
                @if(!is_null($dept))
                    <div class="mt-4 font-size-10">{{ $dept->name }}</div>
                @endif
                <div class="mt-4 font-size-10">Дата створення: {{ $order->created_at }}</div>
            </div>
            @if(Auth::user()->isWorker() && $order->status == 'new' && (is_null($my_proposal) || !$my_proposal->blocked) && !Auth::user()->banned)
                <button class="btn badge-pill text-white bg-deep-blue px-0 col-xl-3 col-6 offset-xl-8 offset-6 mt-4 mb-2" data-toggle="collapse" data-target="#prop" aria-expanded="true">
                    {{ is_null($my_proposal) ? 'Залишити пропозицію' : 'Змінити пропозицію' }}
                </button>
            @elseif(Auth::id() == $order->id_customer && $order->status == 'new' && !Auth::user()->banned)
                <div class="row mt-4">
                    <div class="col-xl-3 col-6 offset-xl-5 offset-6">
                        <button class="btn badge-pill text-white bg-deep-blue mb-2 w-100" data-toggle="collapse" data-target="#edit-order" aria-expanded="false">
                            Змінити замовлення
                        </button>
                    </div>
                    <div class="col-xl-3 col-6 offset-xl-0 offset-6">
                        <form method="POST" action="{{ route('delete_order', $order->id_order) }}" onsubmit="return confirm('Ви впевнені?');">
                            @csrf
                            <button class="btn badge-pill text-white bg-danger px-0 mb-2 w-100">
                                Видалити замовлення
                            </button>
                        </form>
                    </div>
                </div>
            @elseif($order->status == 'in progress' && Auth::id() == $order->id_customer && !Auth::user()->banned)
                <div class="row mt-4">
                    <div class="col-xl-3 col-6 offset-xl-5 offset-6">
                        <form method="POST" action="{{ route('finish_order', $order->id_order) }}" onsubmit="return confirm('Ви впевнені?');">
                            @csrf
                            <button type="submit" class="btn badge-pill text-white bg-deep-blue mb-2 w-100">
                                Замовлення виконано
                            </button>
                        </form>
                    </div>
                    <div class="col-xl-3 col-6 offset-xl-0 offset-6">
                        <button class="btn badge-pill text-white bg-danger px-0 mb-2 w-100" data-toggle="collapse" data-target="#accepted_order" aria-expanded="false">
                            Змінити виконавця
                        </button>
                    </div>
                </div>
            @endif
            <div class="mt-2 to-profile pointer" data-id="{{ $order->id_customer }}">
                <img src="{{ $customer->avatar }}" class="square-100 avatar circle">
            </div>
            <div class="container text-left">
                <div class="row mb-2">
                    <div class="col-11 offset-1 font-weight-bold mt-1">{{ $customer->name }} {{ $customer->surname }}</div>
                    <div class="col-11 offset-1 font-size-10">E-mail: {{ $customer->email }}</div>
                    <div class="col-11 offset-1 font-size-10">Phone number: {{ $customer->phone_number }}</div>
                    <div class="col-11 offset-1 font-size-10">Viber: {{ $customer->viber }}</div>
                    <div class="col-11 offset-1 font-size-10">Skype: {{ $customer->skype }}</div>
                </div>
            </div>
            -->
        </div>
        <!--
        <div class="col-3 text-white text-center align-self-start c_rounded-right mt-4 mb-2 bg-deep-blue">
            <div class="mt-2 to-profile pointer" data-id="{{ $order->id_customer }}">
                <img src="{{ $customer->avatar }}" class="square-100 avatar circle">
            </div>
            <div class="container text-left">
                <div class="row mb-2">
                    <div class="col-11 offset-1 font-weight-bold mt-1">{{ $customer->name }} {{ $customer->surname }}</div>
                    <div class="col-11 offset-1 font-size-10">E-mail: {{ $customer->email }}</div>
                    <div class="col-11 offset-1 font-size-10">Phone number: {{ $customer->phone_number }}</div>
                    <div class="col-11 offset-1 font-size-10">Viber: {{ $customer->viber }}</div>
                    <div class="col-11 offset-1 font-size-10">Skype: {{ $customer->skype }}</div>
                </div>
            </div>
        </div>
        <div class="col-9 mt-4 px-0">
            @if(Auth::user()->isWorker() && $order->status == 'new' && (is_null($my_proposal) || !$my_proposal->blocked) && !Auth::user()->banned)
                <div id="prop" class="collapse">
                    <p class="font-size-18 font-weight-bold">{{ is_null($my_proposal) ? 'Залишити пропозицію' : 'Змінити пропозицію' }}</p>
                    <form method="POST" action="{{ route('add_proposal', $order->id_order) }}" class="col mt-2 bg-white shadow c_rounded">
                        @csrf
                        <div class="form-group row">
                            <label for="price" class="col-sm-2 col-form-label mt-2">Ціна:</label>
                            <div class="col-sm-3 mt-2">
                                <input type="number" id="price" class="form-control" min="0" name="price" value="{{ !is_null($my_proposal) ? $my_proposal->price : '' }}">
                            </div>
                            <select class="col-sm-1 mt-2 px-0 form-control" name="currency">
                                <option {{ !is_null($my_proposal) ? ($my_proposal->currency == 'грн.' ? 'selected' : '') : '' }}>грн.</option>
                                <option {{ !is_null($my_proposal) ? ($my_proposal->currency == '$' ? 'selected' : '') : '' }}>$</option>
                            </select>
                        </div>
                        <div class="form-group row">
                            <label for="time" class="col-sm-2 col-form-label">Час:</label>
                            <div class="col-sm-3">
                                <input type="number" id="time" class="form-control" min="0" name="time" value="{{ !is_null($my_proposal) ? $my_proposal->time : '' }}">
                            </div>
                            <select class="col-sm-1 px-0 form-control" name="type">
                                <option {{ !is_null($my_proposal) ? ($my_proposal->type != 'год.' ? 'selected' : '') : '' }}>дні</option>
                                <option {{ !is_null($my_proposal) ? ($my_proposal->type == 'год.' ? 'selected' : '') : '' }}>год.</option>
                            </select>
                        </div>
                        <div class="form-group row">
                            <label for="comment" class="col-sm-2 col-form-label">Коментар:</label>
                            <div class="col-sm-10">
                                <textarea id="comment" class="form-control" rows="3" name="text" required>{{ !is_null($my_proposal) ? $my_proposal->text : '' }}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <button type="submit" class="col-lg-2 col-5 offset-lg-8 offset-6 text-white btn badge-pill bg-deep-blue mb-2 px-0" name="form_proposals">Підтвердити</button>
                            <button {{ is_null($my_proposal) ? 'type=reset' : '' }} class="col-lg-2 col-5 offset-lg-0 offset-6 btn badge-pill mb-2 px-0" name="delete_proposal">{{is_null($my_proposal) ? 'Скинути' : 'Видалити'}}</button>
                        </div>
                    </form>
                </div>
            @elseif($order->status == 'in progress' && Auth::id() == $order->id_customer && !Auth::user()->banned)
                <div id="accepted_order" class="collapse">
                    <p class="font-size-18 font-weight-bold">Залишити відгук виконавцю</p>
                    <form method="POST" action="{{ route('change_worker', $order->id_order) }}" class="col bg-white shadow c_rounded">
                        @csrf
                        <div class="form-group row">
                            <p class="col-2 mt-3">Без відгуку:</p>
                            <div class="col-3 mt-3">
                                <input type="checkbox" class="form-check-input disable-comment">
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
            @if(Auth::id() == $order->id_customer && $order->status == 'new' && !Auth::user()->banned)
                <div class="container collapse" id="edit-order">
                    <div class="d-flex flex-row">
                        <form class="col bg-white shadow" method="POST" action="{{ route('edit_order', $order->id_order) }}">
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
                                            <option value="{{ $select->id_category }}">{{ $select->name }}</option>
                                        @endforeach
                                    </select>
                                    <div style="display: none">
                                        <input type="text" name="categories" value="{{ $data['string'] }}">
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
                                <button type="submit" class="col-lg-2 col-5 offset-lg-8 offset-6 text-white btn badge-pill bg-deep-blue mb-2 px-0" name="edit_order">Підтвердити</button>
                                <button type="reset" class="col-lg-2 col-5 offset-lg-0 offset-6 btn badge-pill mb-2 px-0 badges_reset">Скинути</button>
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
                            <div class="d-flex flex-row mb-3 mt-2 {{ Auth::user()->id == $order->id_customer && !Auth::user()->banned ? 'pointer' : ''}}">
                                <div class="col-1 px-0 min-width-70 pointer to-profile" data-id="{{ $comment->id_user }}">
                                    <img src="{{ $comment->avatar }}" class="mt-1 square-60 avatar square">
                                </div>
                                <div class="col-9 shadow bg-white" data-id="{{ $comment->id_user }}">
                                    <div class="flex-row" @if(Auth::id() == $order->id_customer && !Auth::user()->banned) data-toggle="collapse" data-target="#w-id-{{ $comment->id_user }}" aria-expanded="true"@endif>
                                        <div class="font-weight-bold mt-2"><span class="pointer to-profile" data-id="{{ $comment->id_user }}">{{ $comment->name }} {{ $comment->surname }}</span></div>
                                        <div class="">{{ $comment->text }}</div>
                                        <div class="text-right font-size-10">{{ $comment->created_at }}</div>
                                    </div>
                                    @if(Auth::id() == $order->id_customer && $order->status == 'new' && !Auth::user()->banned)
                                        <form method="POST" action="{{ route('select_worker', $order->id_order) }}" class="col c_rounded select_worker">
                                            @csrf
                                            <div class="collapse" id="w-id-{{ $comment->id_user }}" aria-expanded="false">
                                                <button type="submit" class="col-lg-3 col-6 offset-lg-8 offset-5 text-white btn badge-pill bg-deep-blue mb-2 px-0" name="selected_worker" value="{{$comment->id_user}}">Підтвердити</button>
                                            </div>
                                        </form>
                                    @endif
                                </div>
                                <div class="col c_rounded-right bg-green text-white mt-3 align-self-end" style="height: 54px; !important;">
                                    <div class="text-center font-weight-bold mt-1">{{ $comment->price }}&nbsp;</div>
                                    <div class="text-right font-italic font-size-10 mt-2">{{ $comment->time }}&nbsp;</div>
                                </div>
                            </div>
                        @endforeach
                    @elseif(count($proposals) == 0)
                        <div class="font-weight-bold font-size-18 mb-4 mt-4">Немає залишених пропозицій</div>
                    @endif
                </div>
                {{ $proposals->links('layouts.pagination') }}
            </div>
        </div>-->
        </div>
        <div class="row">
            <div class="col-12 text-center">
                @if(Auth::user()->isWorker() && $order->status == 'new' && (is_null($my_proposal) || !$my_proposal->blocked) && !Auth::user()->banned)
                    <button class="btn text-white" data-toggle="collapse" data-target="#prop" aria-expanded="true">
                        &#8595;&nbsp;{{ is_null($my_proposal) ? 'Залишити пропозицію' : 'Змінити пропозицію' }}&nbsp;&#8595;
                    </button>
                @elseif(Auth::id() == $order->id_customer && $order->status == 'new' && !Auth::user()->banned)
                    <div class="row mt-4">
                        <div class="col-xl-3 col-6 offset-xl-5 offset-6">
                            <button class="btn badge-pill text-white bg-deep-blue mb-2 w-100" data-toggle="collapse" data-target="#edit-order" aria-expanded="false">
                                Змінити замовлення
                            </button>
                        </div>
                        <div class="col-xl-3 col-6 offset-xl-0 offset-6">
                            <form method="POST" action="{{ route('delete_order', $order->id_order) }}" onsubmit="return confirm('Ви впевнені?');">
                                @csrf
                                <button class="btn badge-pill text-white bg-danger px-0 mb-2 w-100">
                                    Видалити замовлення
                                </button>
                            </form>
                        </div>
                    </div>
                @elseif($order->status == 'in progress' && Auth::id() == $order->id_customer && !Auth::user()->banned)
                    <div class="row mt-4">
                        <div class="col-xl-3 col-6 offset-xl-5 offset-6">
                            <form method="POST" action="{{ route('finish_order', $order->id_order) }}" onsubmit="return confirm('Ви впевнені?');">
                                @csrf
                                <button type="submit" class="btn badge-pill text-white bg-deep-blue mb-2 w-100">
                                    Замовлення виконано
                                </button>
                            </form>
                        </div>
                        <div class="col-xl-3 col-6 offset-xl-0 offset-6">
                            <button class="btn badge-pill text-white bg-danger px-0 mb-2 w-100" data-toggle="collapse" data-target="#accepted_order" aria-expanded="false">
                                Змінити виконавця
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>

    </div>
        <div class="row">
            <div class="col-12 bg-light-grey text-white my-4 shadow-lg">
                @if(Auth::user()->isWorker() && $order->status == 'new' && (is_null($my_proposal) || !$my_proposal->blocked) && !Auth::user()->banned)
                    <div id="prop" class="collapse py-4">
                    <!--<p class="font-size-18 font-weight-bold">{{ is_null($my_proposal) ? 'Залишити пропозицію' : 'Змінити пропозицію' }}</p>-->
                        <form method="POST" action="{{ route('add_proposal', $order->id_order) }}" class="col mt-2shadow c_rounded">
                            @csrf
                            <div class="row">
                                <div class="col-5 offset-1">
                                    <div class="form-group row">
                                        <label for="comment" class="col-form-label">Опис пропозиції:</label>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-12">
                                            <textarea id="comment" class="form-control text-white border-0 bg-deep-dark" rows="4" name="text" required>{{ !is_null($my_proposal) ? $my_proposal->text : '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-5">
                                    <div class="form-group row">
                                        <label for="price" class="col-sm-2 col-form-label">Ціна:</label>
                                        <div class="col-sm-8">
                                            <input type="number" id="price" class="form-control text-white border-0 bg-deep-dark" min="0" name="price" value="{{ !is_null($my_proposal) ? $my_proposal->price : '' }}">
                                        </div>
                                        <select class="col-sm-2 px-0 form-control text-white border-0 bg-deep-dark" name="currency">
                                            <option {{ !is_null($my_proposal) ? ($my_proposal->currency == 'грн.' ? 'selected' : '') : '' }}>грн.</option>
                                            <option {{ !is_null($my_proposal) ? ($my_proposal->currency == '$' ? 'selected' : '') : '' }}>$</option>
                                        </select>
                                    </div>
                                    <div class="form-group row">
                                        <label for="time" class="col-sm-2 col-form-label">Час:</label>
                                        <div class="col-sm-8">
                                            <input type="number" id="time" class="form-control text-white border-0 bg-deep-dark" min="0" name="time" value="{{ !is_null($my_proposal) ? $my_proposal->time : '' }}">
                                        </div>
                                        <select class="col-sm-2 px-0 form-control text-white border-0 bg-deep-dark" name="type">
                                            <option {{ !is_null($my_proposal) ? ($my_proposal->type != 'год.' ? 'selected' : '') : '' }}>дні</option>
                                            <option {{ !is_null($my_proposal) ? ($my_proposal->type == 'год.' ? 'selected' : '') : '' }}>год.</option>
                                        </select>
                                    </div>
                                    <div class="form-group row">
                                        <button type="submit" class="col-5 text-white btn badge-pill bg-green mb-2 px-0" name="form_proposals">Підтвердити</button>
                                        <button {{ is_null($my_proposal) ? 'type=reset' : '' }} class="col-5 btn badge-pill text-white mb-2 px-0" name="delete_proposal">{{is_null($my_proposal) ? 'Скинути' : 'Видалити'}}</button>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                @elseif($order->status == 'in progress' && Auth::id() == $order->id_customer && !Auth::user()->banned)
                    <div id="accepted_order" class="collapse py-4">
                        <p class="font-size-18 font-weight-bold">Залишити відгук виконавцю</p>
                        <form method="POST" action="{{ route('change_worker', $order->id_order) }}" class="col">
                            @csrf
                            <div class="form-group row">
                                <label for="disable-comment" class="col-2 mt-3">Без відгуку:</label>
                                <div class="col-3 mt-3">
                                    <input type="checkbox" id="disable-comment" class="form-check-input disable-comment">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="rating" class="col-2">Оцінка:</label>
                                <div class="col-3 rating">
                                    <input type="range" id="rating" class="form-control reviews-rating" name="rating" min="1" max="5" step="0.5" value="3">
                                </div>
                                <div class="">
                                    <span id="rating_val">3</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="comment" class="col-1 col-form-label">Коментар:</label>
                                <div class="col offset-1">
                                    <textarea id="comment" class="form-control text-white border-0 bg-deep-dark reviews-comment" rows="3" name="text" required></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <button type="submit" class="col-3 offset-8 text-white btn badge-pill bg-green mb-2 px-0" name="leave_review">Підтвердити</button>
                            </div>
                        </form>
                    </div>
                @endif
                    @if(Auth::id() == $order->id_customer && $order->status == 'new' && !Auth::user()->banned)
                        <div class="container collapse py-4" id="edit-order">
                            <div class="d-flex flex-row">
                                <!--
                                <form class="col bg-white shadow" method="POST" action="{{ route('edit_order', $order->id_order) }}">
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
                                                    <option value="{{ $select->id_category }}">{{ $select->name }}</option>
                                                @endforeach
                                            </select>
                                            <div style="display: none">
                                                <input type="text" name="categories" value="{{ $data['string'] }}">
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
                                        <button type="submit" class="col-lg-2 col-5 offset-lg-8 offset-6 text-white btn badge-pill bg-deep-blue mb-2 px-0" name="edit_order">Підтвердити</button>
                                        <button type="reset" class="col-lg-2 col-5 offset-lg-0 offset-6 btn badge-pill mb-2 px-0 badges_reset">Скинути</button>
                                    </div>
                                </form>
-->
                                <form method="POST" action="{{ route('save_order') }}" enctype="multipart/form-data" class="col-12">
                                    @csrf
                                    <!--
                                    <div class="row">
                                        <div class="col-6 mt-4">
                                            <p class="font-size-35 font-weight-bold bg-orange text-center">Змінити замовлення</p>
                                        </div>
                                    </div>
                                    -->
                                    <div class="d-flex flex-row justify-content-around">
                                        <div class="form-group col-6">
                                            <label for="title" class="">Назва</label>
                                            <input type="text" class="form-control text-white border-0 bg-deep-dark" id="title" name="title">
                                            <label for="description" class="mt-2">Інформація</label>
                                            <textarea class="form-control text-white border-0 bg-deep-dark" name="description" id="description" rows="5" required></textarea>
                                            <input id="add-files" type="file" class="btn badge-pill bg-white mt-2" multiple="multiple" name="files[]">
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="price" class="">Ціна</label>
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
                                                    @foreach($themes as $select)
                                                        <option class="" value="{{ $select->id_category }}">{{ $select->name }}</option>
                                                    @endforeach
                                                </select>
                                                <div style="display: none">
                                                    <input type="text" name="categories">
                                                </div>
                                                <div class="form-group row">
                                                    <div class="" id="themes_block"></div>
                                                </div>
                                            </div>
                                            <div class="form-group mb-2">
                                                <div class="" id="themes_block"></div>
                                            </div>
                                            <div class="d-flex justify-content-center mt-4">
                                                <button class="btn badge-pill text-white bg-green">Підтвердити</button>
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
                        <div class="font-weight-bold font-size-18 mt-4">Пропозиції виконавців</div>
                        @foreach($proposals as $comment)
                            <div class="d-flex flex-column mb-3 mt-2 shadow-lg p-2">
                                <div class="d-flex flex-row align-items-center">
                                    <div class="min-width-70 pointer to-profile" data-id="{{ $comment->id_user }}">
                                        <img src="{{ $comment->avatar }}" class="square-54 circle avatar">
                                    </div>
                                    <div class="" @if(Auth::id() == $order->id_customer && !Auth::user()->banned)@endif>
                                        <div class="font-weight-bold"><span class="to-profile pointer" data-id="{{ $comment->id_user }}">{{ $comment->name }} {{ $comment->surname }}</span></div>
                                    </div>
                                    @if(Auth::id() == $order->id_customer && $order->status == 'new' && !Auth::user()->banned)
                                        <form method="POST" action="{{ route('select_worker', $order->id_order) }}" class="col select_worker">
                                            @csrf
                                            <div class="" id="w-id-{{ $comment->id_user }}" aria-expanded="false">
                                                <button type="submit" class="col-3 text-white btn rounded bg-green float-right" name="selected_worker" value="{{$comment->id_user}}">Підтвердити</button>
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
                    @elseif(count($proposals) == 0)
                        <div class="font-weight-bold font-size-18 my-4">Немає залишених пропозицій</div>
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
