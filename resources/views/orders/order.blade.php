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
        <div class="col-9 text-white" style="background-color: #0076de">
            <div class="container">
                <div class="row">
                    <div class="col-3 offset-1">Shop</div>
                    <div class="col-1 offset-5">Ціна:</div>
                    <div class="col-1">132</div>
                </div>
            </div>
            <div class="tags">#full #blah</div>
            <div class="description">

            </div>
        </div>
    </div>
</div>


    
@endsection

@section('footer')
    @include('site.footer')
@endsection