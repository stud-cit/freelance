@extends('layouts.site')

@section('header')
    @include('site.header')
@endsection

@section('content')

@php($data = $info['data'])
@php($dept = $info['dept'])
@php($active = $info['active'])
@php($complete = $info['complete'])
@php($orders = $info['orders'])
@php($proposals = $info['proposals'])
@php($progress = $info['progress'])

<div class="container">
    <div class="row">
        <div class="col">
            <nav class="nav nav-tabs flex-column flex-md-row text-center" id="nav-tab">
                <a class="nav-item nav-link active" id="nav-new-tab" data-toggle="tab" href="#nav-new" role="tab" aria-controls="nav-new" aria-selected="true">Залишені пропозиції</a>
                <a class="nav-item nav-link" id="nav-active-tab" data-toggle="tab" href="#nav-active" role="tab" aria-controls="nav-active" aria-selected="false">Активні проєкти</a>
                <a class="nav-item nav-link" id="nav-complete-tab" data-toggle="tab" href="#nav-complete" role="tab" aria-controls="nav-complete" aria-selected="false">Завершені проєкти</a>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="container mt-4 tab-pane fade show active" id="nav-new" role="tabpanel" aria-labelledby="nav-new-tab">
                    <div class="text-white">
                        @php($i = 0)
                        @foreach($proposals as $all)
                            @if($all->status == 'new')
                                @php($i++)
                                <div class="container shadow-box mb-4 orders">
                                    <div class="d-flex row justify-content-between align-items-center">
                                        <div class="font-weight-bold order-title font-size-25 col-md col-12">{{ $all->title }}</div>
                                        <div class="row col-md-2 col">
                                            <div class="align-self-center ml-4">
                                                @if($all->files)
                                                    <img src="{{ asset('/edit.svg') }}" alt="edit" width="20px" id="edit">
                                                @endif
                                            </div>
                                            <div class="align-self-center ml-1">
                                                @if($all->time)
                                                    <img src="{{ asset('/calendar.svg') }}" alt="calendar" width="20px" id="calendar">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="text-center font-weight-bold font-size-25 col-md-2 col">{{ $all->price }}</div>
                                    </div>
                                    <div class="text-grey d-md-block d-none">{{ $all->created_at }}</div>
                                    <div class="font-size-22 d-md-block d-none">{{ $all->description }}</div>
                                    <div class="font-size-20">Замовник:
                                        <span class="to-profile pointer" data-id="{{ $all->id_customer }}">{{ $all->name }} {{ $all->surname }}</span>
                                    </div>
                                    <div class="d-flex flex-row justify-content-between">
                                        <div class="d-flex justify-content-start align-items-center">
                                            <div class="tag-list d-md-block d-none">
                                                @foreach($all->categories as $tags)
                                                    <span class="btn border-grey mt-1">
                                                        <span class="text-grey">{{ $tags->name }}</span>
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="d-flex col-md col-12 justify-content-md-end justify-content-center mt-md-0 mt-4">
                                            <button class="btn work-order bg-orange text-white" data-id="{{ $all->id_order }}">Переглянути</button>
                                        </div>
                                    </div>
                                    <hr class="border-grey pb-4">
                                </div>
                            @endif
                        @endforeach
                        @if(!$i)
                            <div class="d-flex justify-content-center mt-4">
                                <div class="font-size-30 font-weight-bold">Немає залишених пропозицій</div>
                            </div>
                        @endif
                    </div>
                    <hr class="border-white w-100">
                </div>
                <div class="container mt-4 tab-pane fade show" id="nav-active" role="tabpanel" aria-labelledby="nav-active-tab">
                    <div class="text-white">
                        @php($i = 0)
                        @foreach($proposals as $active)
                            @if($active->status == 'in progress')
                                @php($i++)
                                <div class="container shadow-box mb-4 orders">
                                    <div class="d-flex row justify-content-between align-items-center">
                                        <div class="font-weight-bold order-title font-size-25 col-md col-12">{{ $active->title }}</div>
                                        <div class="row col-md-2 col">
                                            <div class="align-self-center ml-4">
                                                @if($active->files)
                                                    <img src="{{ asset('/edit.svg') }}" alt="edit" width="20px" id="edit">
                                                @endif
                                            </div>
                                            <div class="align-self-center ml-1">
                                                @if($active->time)
                                                    <img src="{{ asset('/calendar.svg') }}" alt="calendar" width="20px" id="calendar">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="text-center font-weight-bold font-size-25 col-md-2 col">{{ $active->price }}</div>
                                    </div>
                                    <div class="text-grey d-md-block d-none">{{ $active->created_at }}</div>
                                    <div class="font-size-20 d-md-block d-none">{{ $active->description }}</div>
                                    <div class="font-size-20">Замовник:
                                        <span class="to-profile pointer" data-id="{{ $active->id_customer }}">{{ $active->name }} {{ $active->surname }}</span>
                                    </div>
                                    <div class="d-flex flex-row justify-content-between">
                                        <div class="d-flex justify-content-start align-items-center">
                                            <div class="tag-list d-md-block d-none">
                                                @foreach($all->categories as $tags)
                                                    <span class="btn border-grey mt-1">
                                                        <span class="text-grey">{{ $tags->name }}</span>
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="d-flex col-md col-12 justify-content-md-end justify-content-center mt-md-0 mt-4">
                                            <button class="btn work-order bg-orange text-white" data-id="{{ $active->id_order }}">Переглянути</button>
                                        </div>
                                    </div>
                                    <hr class="border-grey pb-4">
                                </div>
                            @endif
                        @endforeach
                        @if(!$i)
                            <div class="d-flex justify-content-center mt-4">
                                <div class="font-size-30 font-weight-bold">Немає активних проєктів</div>
                            </div>
                        @endif
                    </div>
                    <hr class="border-white w-100">
                </div>
                <div class="container mt-4 tab-pane fade show" id="nav-complete" role="tabpanel" aria-labelledby="nav-complete-tab">
                    <div class="text-white">
                        @php($i = 0)
                        @foreach($proposals as $complete)
                            @if($complete->status == 'complete')
                                @php($i++)
                                <div class="container shadow-box mb-4 orders">
                                    <div class="d-flex row justify-content-between align-items-center">
                                        <div class="font-weight-bold order-title font-size-25 col-md col-12">{{ $complete->title }}</div>
                                        <div class="text-md-center font-weight-bold font-size-25 col-md-2 col">{{ $complete->price }}</div>
                                    </div>
                                    <div class="text-grey d-md-block d-none">{{ $complete->created_at }}</div>
                                    <div class="font-size-20 d-md-block d-none">{{ $complete->description }}</div>
                                    <div class="d-flex row justify-content-between align-items-center">
                                        <div class="d-flex justify-content-start col-md col-12">
                                            <div class="font-size-20">Замовник:
                                                <span class="to-profile pointer" data-id="{{ $complete->id_customer }}">{{ $complete->name }} {{ $complete->surname }}</span>
                                            </div>
                                        </div>
                                        @if($complete->review)
                                        <div class="d-flex justify-content-md-end justify-content-center mt-md-0 mt-4 col-md col-12">
                                            <button class="btn bg-orange text-white" data-toggle="collapse" data-target="#id-{{ $complete->id_proposal }}">Залишити відгук</button>
                                        </div>
                                        @endif
                                    </div>
                                    <div id="id-{{ $complete->id_proposal }}" class="container collapse bg-light-grey mt-4">
                                        <form method="POST" action="{{ route('save_review', $complete->id_order) }}" class="col">
                                            @csrf
                                            <div class="form-group row">
                                                <label for="rating" class="col-md-2 col-12">Оцінка:</label>
                                                <div class="col-md-3 col-10 rating">
                                                    <input type="range" id="rating" class="form-control reviews-rating" name="rating" min="1" max="5" step="0.5" value="3">
                                                </div>
                                                <div class="">
                                                    <span id="rating_val">3</span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="comment" class="col-md-1 col-1 col-form-label">Коментар:</label>
                                                <div class="col-md col-12 offset-md-1">
                                                    <textarea id="comment" class="form-control text-white border-0 bg-deep-dark reviews-comment" rows="3" name="text" required></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <button type="submit" class="col-md-3 col-10 offset-md-8 offset-1 text-white btn badge-pill bg-green mb-2 px-0" name="leave_review">Підтвердити</button>
                                            </div>
                                        </form>
                                    </div>
                                    <hr class="border-grey pb-4">
                                </div>
                            @endif
                        @endforeach
                        @if(!$i)
                            <div class="d-flex justify-content-center">
                                <div class="font-size-30 font-weight-bold">Немає завершених проєктів</div>
                            </div>
                        @endif
                    </div>
                    <hr class="border-white w-100">
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('footer')
    @include('site.footer')
@endsection
