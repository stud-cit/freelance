@extends('layouts.site')

@section('header')
    @include('site.header')
@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col-9">
            <a href="{{}}" class="btn">Пошук</a>
        </div>
        <div class="col-9" style="background-color: #0076de">
            <div class="container text-white">
                <div class="row">
                    <div class="col-3 offset-1">Shop</div>
                    <div class="col-1 offset-2">Ціна:</div>
                    <div class="col-1">132</div>
                </div>
            </div>
        </div>
    </div>
</div>


    
@endsection

@section('footer')
    @include('site.footer')
@endsection