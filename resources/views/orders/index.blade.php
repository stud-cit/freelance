@extends('layouts.site')

@section('header')
    @include('site.header')
@endsection

@section('content')

<div class="container mt-5" xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div class="row">
        <div class="col-8">
            <div class="container">
                <div class="row">
                    <div class="col-3 font-weight-bold text-left" style="Font: Lora; font-size: 18px">Всі проекти</div>
                    <div class="col-7 offset-2">
                        <form action="">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="col-form-label">фільтрувати за:</span>
                                </div>
                                <div>
                                    <select name="ondate" class="form-control border-0">
                                        <option value="" selected disabled>датою</option>
                                        <option value="1">1</option>
                                    </select>
                                </div>
                                <div>
                                    <select name="ondate" class="form-control border-0">
                                        <option value="" selected disabled>оплатою</option>
                                        <option value="1">1</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div id="orders" class="container">
                @foreach($data as $orders)
                <div class="row mb-3 mt-2">
                    <div class="col-10 shadow bg-white rounded work-order" style="" v-on:click="redirect({{$orders->id_order}})">
                        <div id="title">{{$orders->title}}</div>
                        <div id="description">{{$orders->description}}</div>
                        <div id="created_at" class="text-right" style="font-size: 8px">{{$orders->created_at}}</div>
                    </div>
                    <div class="col rounded-right" style="background-color: #00B060; color: #ffffff">
                        <div id="price" class="text-center font-weight-bold" style="font-size: 20px">{{$orders->price}}</div>
                        <div id="time" class="text-right font-italic" style="font-size: 10px">{{$orders->time}}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="col-3 offset-1">

            <div class="card text-center px-0 mb-4">
                <div class="card-header text-white font-weight-bold rounded-top" style="background-color: #0076de">Фільтр</div>
                <div class="card-body">
                    <input type="text">
                    <div class="form-group row mt-4">
                        <div class="col-lg-6 col-12">
                            <button type="submit" class="btn text-white badge-pill w-100" style="background-color: #0076de">
                                Пошук
                            </button>
                        </div>
                        <div class="col-lg-6 col-12">
                            <button type="submit" class="btn btn-outline-secondary badge-pill w-100">
                                Скинути
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header font-weight-bold">Топ виконавців</div>
                <div class="card-body">
                    @foreach($workers as $users)
                    <!--<img src="" alt=""> for avatar -->
                    <div id="name">{{$users->name}} {{$users->surname}}</div>
                    <div id="about_me">{{$users->about_me}}</div>
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
