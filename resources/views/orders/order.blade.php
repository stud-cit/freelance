@extends('layouts.site')

@section('header')
    @include('site.header')
@endsection

@section('content')

    @php($order = $data['order'])
    @php($customer = $data['customer'])
    @php($proposals = $data['proposals'])
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
            <div class="offset-1">
                <div class="tags font-italic font-size-10">#full #blah</div>
                <div class="mt-4 font-size-10">{{$order->description}}</div>
                <div class="mt-4 font-size-10">Дата створення: {{$order->created_at}}</div>
            </div>
            @if(Auth::user()->isWorker())
                <button type="submit" id="propose-toggle" class="btn badge-pill text-white bg-deep-blue px-0 col-3 offset-8 mt-4">
                    Видвинути пропозицію
                </button>
            @elseif(Auth::user()->id)
                <button type="submit" id="propose-toggle" class="btn badge-pill text-white bg-deep-blue px-0 col-3 offset-8 mt-4">
                    Обрати виконавця
                </button>
            @endif
        </div>
        <div class="col-3 text-white text-center c_rounded-right mt-4 mb-2 bg-deep-blue">
            <div class="mt-2">
                <img src="{{$customer->avatar}}" class="square-100 avatar circle">
            </div>
            <div class="container text-left">
                <div class="row mb-2">
                    <div class="col-11 offset-1 font-weight-bold">{{$customer->name}} {{$customer->surname}}</div>
                    <div class="col-11 offset-1 font-size-10">comp order</div>
                    <div class="col-11 offset-1 font-size-10">E-mail: {{$customer->email}}</div>
                    <div class="col-11 offset-1 font-size-10">Phone number: {{$customer->phone_number}}</div>
                    <div class="col-11 offset-1 font-size-10">Viber: {{$customer->viber}}</div>
                    <div class="col-11 offset-1 font-size-10">Skype: {{$customer->skype}}</div>
                </div>
            </div>
        </div>
        <div class="col-8 mt-4 px-0">
            @if(Auth::user()->isWorker())
            <div id="prop" style="display: none;">
                <p class="font-size-18 font-weight-bold">Видвинути пропозицію</p>
                <form method="POST" action="{{ route('add_proposal', $order->id_order) }}" class="col mt-2 shadow-lg c_rounded">
                    @csrf
                    <div class="form-group row">
                        <label for="price" class="col-sm-2 col-form-label mt-2">Ціна:</label>
                        <div class="col-sm-3 mt-2">
                            <input type="number" id="price" class="form-control" name="price">
                        </div>
                        <select class="col-sm-1 mt-2 px-0 form-control" name="currency">
                            <option>грн.</option>
                            <option>$</option>
                        </select>
                    </div>
                    <div class="form-group row">
                        <label for="time" class="col-sm-2 col-form-label">Час:</label>
                        <div class="col-sm-3">
                            <input type="number" id="time" class="form-control" name="time">
                        </div>
                        <select class="col-sm-1 px-0 form-control" name="type">
                            <option>дні</option>
                            <option>год.</option>
                        </select>
                    </div>
                    <div class="form-group row">
                        <label for="comment" class="col-sm-2 col-form-label">Коментар:</label>
                        <div class="col-sm-10">
                            <textarea id="comment" class="form-control" rows="3" name="text" required></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <button type="submit" class="col-lg-2 col-3 offset-lg-8 offset-5 text-white btn badge-pill bg-deep-blue  mb-2 px-0">Підтвердити</button>
                        <button type="reset" class="col-lg-2 col-3 offset-lg-0 offset-5 btn badge-pill mb-2 px-0">Скинути</button>
                    </div>
                </form>
            </div>
            @elseif(Auth::user()->id)
            <div id="prop" style="display: none;">
                <p class="font-size-18 font-weight-bold">Виконавці</p>
                <form method="POST" action="" class="col shadow-lg c_rounded">
                    <div class="row">
                        @foreach($proposals as $accept)
                            <div class="form-check mb-2 col-5 offset-1">
                                <input class="form-check-input mt-2" name="1" type="radio" id="id-{{ $accept->id_user }}">
                                <img src="{{$accept->avatar}}" class="square-30 avatar circle" id="">
                                <label for="id-{{ $accept->id_user }}" class="form-check-label">{{$accept->name}} {{$accept->surname}}</label>
                            </div>
                        @endforeach
                    </div>

                    <div class="form-group">
                        <button type="submit" class="col-lg-2 col-3 offset-lg-8 offset-5 text-white btn badge-pill bg-deep-blue  mb-2 px-0">Підтвердити</button>
                    </div>
                </form>
            </div>
            @endif
            <div class="col">
                <div class="font-weight-bold font-size-18">Пропозиції виконавців</div>
                <div class="container proposals">
                    @foreach($proposals as $comment)
                        <div class="d-flex flex-row mb-3 mt-2">
                            <div class="col-1 px-0 min-width-70">
                                <img src="{{$comment->avatar}}" class="mt-1 square-60 avatar square">
                            </div>
                            <div class="col-9 shadow bg-white to-profile pointer" data-id="{{$comment->id_user}}">
                                <div class="font-weight-bold mt-2">{{$comment->name}} {{$comment->surname}}</div>
                                <div class="">{{$comment->text}}</div>
                                <div class="text-right font-size-10">{{$comment->created_at}}</div>
                            </div>
                            <div class="col c_rounded-right bg-green text-white mt-3">
                                <div class="text-center font-weight-bold mt-1">{{$comment->price}}</div>
                                <div class="text-right font-italic font-size-10 mt-2">{{$comment->time}}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-3 offset-1 px-0 mt-4">
            <div class="card">
                <div class="card-header text-left font-weight-bold font-size-18">Схожі заяви</div>
                <div class="card-body"> dooot </div>
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
