@extends('layouts.site')

@section('header')
    @include('site.header')
@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col-9">
            <a href="/orders" class="btn">Пошук</a>
        </div>
        <div class="col-9 text-white rounded" style="background-color: #0076de">
            <div class="container">
                <div class="row  mt-4">
                    <div class="col-3 offset-1 font-weight-bold">Shop</div>
                    <div class="col-1 offset-5">Ціна:</div>
                    <div class="col-1 font-weight-bold">132</div>
                </div>
            </div>
            <div class="tags">#full #blah</div>
            <div class="description mt-4">
                some text
            </div>
            <div class="mt-4">Дата створення: </div>
            <div class="col-3 offset-8  mb-4">
                <button type="submit" class="btn badge-pill w-100 text-white" style="background-color: #000367">
                    Видвинути пропозицію
                </button>
            </div>
        </div>
        <div class="col-3 text-white text-center rounded-right mt-4 mb-2" style="background-color: #000367">
            <div>
                <!--<img src="" alt=""> for avatar -->
            </div>
            <div class="container text-left">
                <div class="row">
                    <div class="col-11 offset-1 name surname font-weight-bold">Doot qweqwrq</div>
                    <div class="col-11 offset-1">comp order</div>
                    <div class="col-11 offset-1">E-mail: </div>
                    <div class="col-11 offset-1">Phone number: </div>
                </div>
            </div>
        </div>
        <div class="col-8 mt-4">
            <div>Сворення власної пропозиції</div>
            <div class="shadow">
                <div class="offset-1 mt-4">
                    <label for="">Ціна</label>
                    <input type="text">
                </div>
                <div class="row">
                    <div class="col-3 offset-6">
                        <button type="submit" class="btn badge-pill w-100 text-white mb-2" style="background-color: #000367">
                            Відправити
                        </button>
                    </div>
                    <div class="col-2">
                        <button type="submit" class="btn badge-pill w-100 text-white" style="background-color: #000367">
                            Відмінити
                        </button>
                    </div>
                </div>
            </div>

        </div>
        <div class="card col-3 offset-1 px-0">
            <div class="card-header text-left">Схожі заяви</div>
        </div>
        <div class="col-8 mt-4">
            <div>Пропозиції виконавців</div>
            <div class="container proposals">
                <div class="row mb-3 mt-2">
                    <div class="col-1">
                        <!--<img src="" alt=""> for avatar -->
                    </div>
                    <div class="col-9 shadow bg-white rounded work-order" style="">
                        <div class="name surname font-weight-bold">Doot qwrqrw</div>
                        <div class="comment">Some text</div>
                        <div class="text-right created_at" style="font-size: 8px">20.11.2019</div>
                    </div>
                    <div class="col rounded-right bg-green text-white">
                        <div class="text-center font-weight-bold price" style="font-size: 20px">400</div>
                        <div class="text-right font-italic time" style="font-size: 10px">3 days</div>
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