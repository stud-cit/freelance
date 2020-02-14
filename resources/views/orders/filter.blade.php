@php($count = $info['count'])
@php($page = $info['page'] ?? 1)
@php($data = $info['array'] ?? $info['data'])

@if($data != [])
    <div class="container-fluid" id="orders-list">
        <div class="mt-2 mb-4">
            @foreach($data as $orders)
                <div class="container-fluid shadow-box mb-4 orders">
<!--
                    <div class="d-flex flex-row justify-content-between align-items-center">
                        <div class="d-flex justify-content-start">
                            <div class="d-flex flex-row">
                            </div>
                        </div>
                    </div>
-->
                <div class="row">
                    <div class="col-md-6 col-8 font-weight-bold order-title font-size-20 order-md-1 order-4">{{ $orders->title }}</div>
                    <div class="col-md-2 col-4 justify-content-end d-flex align-items-center order-md-2 order-5">
                        <div class="">
                            @if($orders->files)
                                <img src="{{ asset('/edit.svg') }}" alt="edit" width="20px" id="edit">
                            @endif
                        </div>
                        <div class="">
                            @if($orders->time)
                                <img src="{{ asset('/calendar.svg') }}" alt="calendar" width="20px" id="calendar">
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 col-4 text-center font-weight-bold font-size-20 nowrap justify-content-end order-md-3 order-2">{{ $orders->price }}</div>
                    <div class="col-md-12 col-4 text-md-left text-right text-grey order-md-5 order-7">{{ $orders->created_at }}</div>
                    <div class="col-md-12 col-7 order-md-6 order-6">{{ $orders->description }}</div>
                    @if(!is_null($orders->dept))
                        <div class="col-md-12 col-4 text-grey order-md-8 order-9">{{ $orders->dept->name }}</div>
                    @endif
                    <div class="col-md-8 col-8 tag-list order-md-9 order-1">
                        @foreach($orders->categories as $tags)
                            <span class="btn border-grey">
                                        <span class="text-grey">{{ $tags->name }}</span>
                                    </span>
                        @endforeach
                    </div>
                    <div class="col-md-4 col-4 d-md-none d-block text-center order-10">
                        <button class="btn bg-primary text-white" onclick="getElementById('form-id').submit();">Зв'язатися</button>
                    </div>

                    <div class="col-md-4 col-4 text-center order-md-10 order-11">
                        <button class="btn work-order bg-orange text-white" data-id="{{ $orders->id_order }}">Переглянути</button>
                        @if(Auth::check() && ($orders->id_customer != Auth::id()))
                            <form method="POST" action="{{ route('new_contact') }}" id="form-id" class="text-center">
                                @csrf
                                <input type="text" name="id_user" class="d-none" value="{{ $orders->id_customer }}">
                                <span class="pointer font-size-12 text-grey d-md-flex d-none" onclick="getElementById('form-id').submit();">Зв'язатися</span>
                            </form>
                        @endif
                    </div>
                    <!--
                    <div class="d-flex justify-content-start align-items-center">
                    </div>
                    <div class="d-flex flex-row justify-content-between">
                        <div class="d-flex flex-column justify-content-end">
                        </div>
                    </div>
                    -->
                    <hr class="col-11 border-grey pb-4 order-md-12 d-none d-md-flex">
                </div>
                </div>
            @endforeach
        </div>
        <div id="pagination" class="flex-row justify-content-center mb-3 {{ ceil($count / 10) < 2 ? 'd-none' : 'd-flex' }}">
            <button class="btn btn-outline-p" @if($page == 1) disabled @endif><<</button>&nbsp;
            <button class="btn btn-outline-p" @if($page == 1) disabled @endif><</button>&nbsp;
            <button class="pagination-num btn btn-outline-p @if($page == 1) pagination-selected active @endif" id="num-1" >1</button>&nbsp;
            @for($i = 2; $i <= ceil($count / 10); $i++)
                <button class="pagination-num btn btn-outline-p @if($page == $i) pagination-selected active @endif" id="num-{{ $i }}">{{ $i }}</button>&nbsp;
            @endfor
            <button class="btn btn-outline-p" @if($page == ceil($count / 10)) disabled @endif>></button>&nbsp;
            <button class="btn btn-outline-p" @if($page == ceil($count / 10)) disabled @endif>>></button>
        </div>
    </div>
@else
    <div class="container-fluid orders" id="orders-list">
        <div class="flex-row">
            <div class="col font-weight-bold font-size-18 text-center mt-4">Немає залишених замовленнь</div>
            <div class="d-flex justify-content-end text-center">
            </div>
        </div>
    </div>
    <div id="pagination" class="mb-3"></div>
@endif
