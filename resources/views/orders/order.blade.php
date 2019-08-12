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
            <a href="/orders" class="btn font-weight-bold font-size-18">&#10094; Пошук</a>
        </div>
        <div class="col-9 text-white c_rounded bg-blue">
                <div class="row mt-4">
                    <div class="col-3 offset-1 font-weight-bold font-size-18">{{$order->title}}</div>
                    <div class="col-1 offset-5 font-size-10 mt-2">Ціна:</div>
                    <div class="col-1 font-weight-bold font-size-18">{{$order->price}}</div>
                </div>
            <div class="offset-1">
                <div class="tags font-italic font-size-10">#full #blah</div>
                <div class="description mt-4  font-size-10">{{$order->description}}</div>
                <div class="mt-4 font-size-10">Дата створення: {{$order->created_at}}</div>
            </div>
            <button type="submit" id="propose-toggle" class="btn badge-pill text-white bg-deep-blue px-0 col-3 offset-8 mb-4" v-on:click="show()">
                Видвинути пропозицію
            </button>
        </div>
        <div class="col-3 text-white text-center c_rounded-right mt-4 mb-2 bg-deep-blue">
            <div>
                <!--<img src="" alt=""> for avatar -->
            </div>
            <div class="container text-left">
                <div class="row">
                    <div class="col-11 offset-1 name surname font-weight-bold">{{$customer->name}} {{$customer->surname}}</div>
                    <div class="col-11 offset-1 font-size-10">comp order</div>
                    <div class="col-11 offset-1 font-size-10">E-mail: {{$customer->email}}</div>
                    <div class="col-11 offset-1 font-size-10">Phone number: {{$customer->phone_number}}</div>
                </div>
            </div>
        </div>

        <div class="col-8 mt-4 px-0">
            <div id="prop">
                <label class="font-size-18 font-weight-bold">Видвинути пропозицію</label>
                <form class="col mt-2 shadow-lg c_rounded" method="POST" action="{{ route('add_proposal', $order->id_order) }}">
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label mt-2">Ціна:</label>
                        <div class="col-sm-3 mt-2">
                            <input type="number" class="form-control" name="price" required>
                        </div>
                        <select class="col-sm-1 mt-2 px-0 form-control" name="currency">
                            <option>грн.</option>
                            <option>$</option>
                        </select>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Час:</label>
                        <div class="col-sm-3">
                            <input type="number" class="form-control" name="time" required>
                        </div>
                        <select class="col-sm-1 px-0 form-control" name="type">
                            <option>дні</option>
                            <option>год.</option>
                        </select>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Коментар:</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" rows="3" name="text" required></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <button type="submit" class="col-lg-2 col-3 offset-lg-8 offset-5 text-white btn badge-pill bg-deep-blue  mb-2 px-0">Підтвердити</button>
                        <button type="reset" class="col-lg-2 col-3 offset-lg-0 offset-5 btn badge-pill mb-2 px-0">Скинути</button>
                    </div>
                </form>
            </div>

            <div class="col">
                <div class="font-weight-bold font-size-18">Пропозиції виконавців</div>
                <div class="container proposals">
                    @foreach($proposals as $comment)
                        <div class="row mb-3 mt-2">
                            <div class="col-1">
                                <!--<img src="" alt=""> for avatar -->
                            </div>
                            <div class="col-9 shadow bg-white work-order" style="">
                                <div class="name surname font-weight-bold mt-2">{{$comment->name}} {{$comment->surname}}</div>
                                <div class="comment">{{$comment->text}}</div>
                                <div class="text-right created_at font-size-10">{{$comment->created_at}}</div>
                            </div>
                            <div class="col c_rounded-right bg-green text-white mt-3">
                                <div class="text-center font-weight-bold font-size-18 price">{{$comment->price}}</div>
                                <div class="text-right font-italic time font-size-10">{{$comment->time}}</div>
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



@endsection

@section('footer')
    @include('site.footer')
@endsection
