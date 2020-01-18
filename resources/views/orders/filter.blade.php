@php($count = $data['count'])
@php($page = $data['page'])
@php($data = $data['array'])

@if($data != [])
    <div class="container-fluid" id="orders-list">
        <div class="mt-2 mb-4">
            @foreach($data as $orders)
                <div class="container-fluid shadow-box mb-4 orders">
                    <div class="d-flex flex-row justify-content-between align-items-center">
                        <div class="d-flex justify-content-start">
                            <div class="d-flex flex-row">
                                <div class="font-weight-bold order-title font-size-30">{{ $orders->title }}</div>
                                <div class="align-self-center ml-4">
                                    @if($orders->files)
                                        <img src="{{ asset('/edit.svg') }}" alt="edit" width="20px" id="edit">
                                    @endif
                                </div>
                                <div class="align-self-center ml-1">
                                    @if($orders->time)
                                        <img src="{{ asset('/calendar.svg') }}" alt="calendar" width="20px" id="calendar">
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="text-center font-weight-bold font-size-30 nowrap justify-content-end">{{ $orders->price }}</div>
                    </div>
                    <div class="text-grey">{{ $orders->created_at }}</div>
                    <div class="font-size-22">{{ $orders->description }}</div>
                    <div class="d-flex flex-row justify-content-between">
                        <div class="d-flex justify-content-start align-items-center">
                            <div class="tag-list">
                                @foreach($orders->categories as $tags)
                                    <span class="btn border-grey">
                                        <span class="text-grey">{{ $tags->name }}</span>
                                    </span>
                                @endforeach
                            </div>
                            @if(!is_null($orders->dept))
                                <div class="text-left float-left text-grey font-size-20 ml-2">{{ $orders->dept->name }}</div>
                            @endif
                        </div>
                        <div class="d-flex flex-column justify-content-end">
                            @if(Auth::check() && !Auth::user()->banned)
                                <button class="btn work-order bg-orange" data-id="{{ $orders->id_order }}">Переглянути</button>
                            @endif
                            <form method="POST" action="{{ route('new_contact') }}" id="form-id" class=" text-center">
                                @csrf
                                <input type="text" name="id_user" class="d-none" value="{{ $orders->id_customer }}">
                                @if(Auth::check() && ($orders->id_customer != Auth::id()))
                                    <span class="pointer font-size-12 text-grey" onclick="getElementById('form-id').submit();">Зв'язатися</span>
                                @endif
                            </form>
                        </div>
                    </div>
                    <hr class="border-grey pb-4">
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
