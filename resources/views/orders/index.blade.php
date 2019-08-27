@extends('layouts.site')

@section('header')
    @include('site.header')
@endsection

@section('content')



<div class="container" xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div class="row">
        <div class="col-8">
            <div class="container">
                <div class="row">
                    <div class="col-3 font-weight-bold text-left font-size-18">Всі проекти</div>
                    <div class="col-7 offset-2">
                        <form action="">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="col-form-label">фільтрувати за:</span>
                                </div>
                                <div>
                                    <select name="on_date" class="form-control border-0">
                                        <option value="" selected disabled>датою</option>
                                        <option value="1">1</option>
                                    </select>
                                </div>
                                <div>
                                    <select name="on_price" class="form-control border-0">
                                        <option value="" selected disabled>оплатою</option>
                                        <option value="1">1</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @if(Auth::user()->idRow == 2)
                <div class="container new-order">
                    <div class="d-flex flex-row mb-3 mt-2">
                        <div class="col-8">Створити власний проект</div>
                        <div class="col-1 circle">&#43;</div>
                    </div>
                </div>
            @endif
            <div class="container orders">
                @foreach($data as $orders)
                <div class="d-flex flex-row mb-3 mt-2">
                    <div class="col-10 shadow bg-white work-order pointer" data-id="{{$orders->id_order}}">
                        <div class=" font-weight-bold mt-2">{{$orders->title}}</div>
                        <div class="">{{$orders->description}}</div>
                        <div class="text-right font-size-10">{{$orders->created_at}}</div>
                    </div>
                    <div class="col c_rounded-right mt-3 bg-green text-white">
                        <div class="text-center font-weight-bold mt-1">{{$orders->price}}</div>
                        <div class="text-right font-italic font-size-10 mt-2">{{$orders->time}}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="col-3 offset-1">
            <div class="card text-center px-0 mb-4">
                <div class="card-header text-white font-weight-bold font-size-18 c_rounded-top bg-blue">Фільтр</div>
                <div class="card-body">
                    <input type="text" class="form-control">
                    <div class="form-group row mt-4">
                        <div class="col-lg-6 col-12">
                            <button type="submit" class="btn text-white badge-pill w-100 bg-violet">
                                Пошук
                            </button>
                        </div>
                        <div class="col-lg-6 col-12">
                            <button type="reset" class="btn btn-outline-secondary badge-pill w-100">
                                Скинути
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <div class="font-weight-bold font-size-18 px-0">Топ виконавців</div>
                <div class="px-0">
                    @foreach($workers as $users)
                    <div class="mt-2">
                        <img src="{{$users->avatar}}" class="square-60 avatar circle">
                        <label class="name surmane font-weight-bold">{{$users->name}} {{$users->surname}}</label>
                    </div>
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
