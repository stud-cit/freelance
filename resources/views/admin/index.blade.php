@extends('layouts.site')

@section('header')
	@include('site.header')
@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col-9">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-ban-tab" data-toggle="tab" href="#nav-ban" role="tab" aria-controls="nav-ban" aria-selected="true">BanHummer</a>
                    <a class="nav-item nav-link" id="nav-orders-tab" data-toggle="tab" href="#nav-orders" role="tab" aria-controls="nav-orders" aria-selected="false">Cancel-Orders</a>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-ban" role="tabpanel" aria-labelledby="nav-ban-tab">
                    <div class="container">
                        <div class="d-flex flex-row mb-3 mt-2 pointer to-profile" data-id="">
                            <div class="col-1 px-0 min-width-90">
                                <img src="" class="mt-1 square-80 avatar square">
                            </div>
                            <div class="col-11 shadow bg-white" data-id="">
                                <div class="flex-row">
                                    <div class="font-weight-bold font-size-18 mt-2"><span class="" data-id="">Doot Dooted</span></div>
                                    <div class="tag-list">
                                    </div>
                                    <div>asdasdadads</div>
                                    <div class="text-right font-size-10">Дата реєстрації: 20.10.1220</div>
                                </div>
                                <div class="col-3 offset-9">
                                    <button class="btn btn-danger mb-2">asd</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-orders" role="tabpanel" aria-labelledby="nav-orders-tab">
                    <div class="container orders" id="orders-list">
                        <div class="flex-row mb-3 mt-2 d-flex">
                            <div class="col-10 shadow bg-white work-order pointer" data-id="">
                                <div class="font-weight-bold mt-2 order-title">qwqweqwe</div>
                                <div class="tag-list">asdaasd
                                </div>
                                <div>qweqweq</div>
                                <div class="text-right font-size-10">asdad</div>
                                <div class="row">
                                    <div class="col-3 offset-6">
                                        <button class="btn mb-2">asd1</button>
                                    </div>
                                    <div class="col-3 ">
                                        <button class="btn btn-danger mb-2">asd2</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col c_rounded-right mt-3 bg-green text-white px-0 align-self-end text-nowrap" style="height: 54px;">
                                <div class="text-center font-weight-bold m-1"></div>
                                <div class="text-right font-italic font-size-10 mt-2 pr-2"></div>
                            </div>
                        </div>
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