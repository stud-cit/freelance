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
                <a class="nav-item nav-link active" id="nav-new-tab" data-toggle="tab" href="#nav-new" role="tab" aria-controls="nav-new" aria-selected="true">Відкриті проєкти</a>
                <a class="nav-item nav-link" id="nav-progress-tab" data-toggle="tab" href="#nav-progress" role="tab" aria-controls="nav-progress" aria-selected="false">Проєкти у процесі</a>
                <a class="nav-item nav-link" id="nav-complete-tab" data-toggle="tab" href="#nav-complete" role="tab" aria-controls="nav-complete" aria-selected="false">Завершені проєкти</a>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="container mt-4 tab-pane fade show active" id="nav-new" role="tabpanel" aria-labelledby="nav-new-tab">
                    <div class="text-white">
                        @php($i = 0)
                        @foreach($orders as $all)
                            @if($all->status == 'new')
                                @php($i++)
                                <div class="container shadow-box mb-4 orders">
                                    <div class="d-flex flex-row justify-content-between align-items-center">
                                        <div class="d-flex justify-content-start">
                                            <div class="d-flex flex-row">
                                                <div class="font-weight-bold order-title font-size-30">{{ $all->title }}</div>
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
                                        </div>
                                        <div class="text-center font-weight-bold font-size-30 nowrap justify-content-end">{{ $all->price }}</div>
                                    </div>
                                    <div class="text-grey">{{ $all->created_at }}</div>
                                    <div class="font-size-22">{{ $all->description }}</div>
                                    <div class="d-flex flex-row justify-content-between">
                                        <div class="d-flex justify-content-start align-items-center">
                                            <div class="tag-list">
                                                @foreach($all->categories as $tags)
                                                    <span class="btn border-grey">
                                                        <span class="text-grey">{{ $tags->name }}</span>
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column justify-content-end">
                                            <button class="btn work-order bg-orange text-white" data-id="{{ $all->id_order }}">Переглянути</button>
                                            @if($all->id_customer == Auth::id())
                                                <form method="POST" action="{{ route('delete_order', $all->id_order) }}" id="delete" class="text-center">
                                                    @csrf
                                                    <span class="pointer font-size-12 text-grey" onclick="getElementById('delete').submit()">Видалити</span>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                    <hr class="border-grey pb-4">
                                </div>
                            @endif
                        @endforeach
                        @if(!$i)
                            <div class="d-flex justify-content-center mt-4">
                                <div class="font-size-30 font-weight-bold">Немає відкритих проєктів</div>
                            </div>
                        @endif
                    </div>
                    <hr class="border-white w-100">
                </div>
                <div class="container mt-4 tab-pane fade show" id="nav-progress" role="tabpanel" aria-labelledby="nav-progress-tab">
                    <div class="text-white">
                        @php($i = 0)
                        @foreach($orders as $active)
                            @if($active->status == 'in progress')
                                @php($i++)
                                <div class="container shadow-box mb-4 orders">
                                    <div class="d-flex flex-row justify-content-between align-items-center">
                                        <div class="d-flex justify-content-start">
                                            <div class="d-flex flex-row">
                                                <div class="font-weight-bold order-title font-size-30">{{ $active->title }}</div>
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
                                        </div>
                                        <div class="text-center font-weight-bold font-size-30 nowrap justify-content-end">{{ $active->price }}</div>
                                    </div>
                                    <div class="text-grey">{{ $active->created_at }}</div>
                                    <div class="font-size-20">Виконавець:
                                        <span class="to-profile pointer" data-id="{{ $active->id_worker }}">{{ $active->worker->name }} {{ $active->worker->surname }}</span>
                                    </div>
                                    <div class="font-size-22">{{ $active->description }}</div>
                                    <div class="d-flex flex-row justify-content-between">
                                        <div class="d-flex justify-content-start align-items-center">
                                            <div class="tag-list">
                                                @foreach($active->categories as $tags)
                                                    <span class="btn border-grey">
                                                        <span class="text-grey">{{ $tags->name }}</span>
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row justify-content-end">
                                            <button class="btn work-order bg-orange text-white" data-id="{{ $active->id_order }}">Переглянути</button>
                                        </div>
                                    </div>
                                    <hr class="border-grey pb-4">
                                </div>
                            @endif
                        @endforeach
                        @if(!$i)
                            <div class="d-flex justify-content-center">
                                <div class="font-size-30 font-weight-bold">Немає проєктів у процесі</div>
                            </div>
                        @endif
                    </div>
                    <hr class="border-white w-100">
                </div>
                <div class="container mt-4 tab-pane fade show" id="nav-complete" role="tabpanel" aria-labelledby="nav-complete-tab">
                    <div class="text-white">
                        @php($i = 0)
                        @foreach($orders as $complete)
                            @if($complete->status == 'complete')
                                @php($i++)
                                <div class="container shadow-box mb-4 orders">
                                    <div class="d-flex flex-row justify-content-between align-items-center">
                                        <div class="d-flex justify-content-start">
                                            <div class="d-flex flex-row">
                                                <div class="font-weight-bold order-title font-size-30">{{ $complete->title }}</div>
                                            </div>
                                        </div>
                                        <div class="text-center font-weight-bold font-size-30 nowrap justify-content-end">{{ $complete->price }}</div>
                                    </div>
                                    <div class="text-grey">{{ $complete->created_at }}</div>
                                    <div class="font-size-22">{{ $complete->description }}</div>
                                    <div class="d-flex flex-row justify-content-between align-items-center">
                                        <div class="d-flex justify-content-start">
                                            <div class="font-size-20">Виконавець:
                                                <span class="to-profile pointer" data-id="{{ $complete->id_worker }}">{{ $complete->worker->name }} {{ $complete->worker->surname }}</span>
                                            </div>
                                        </div>
                                        @if($complete->review)
                                        <div class="d-flex justify-content-end">
                                            <button class="btn bg-orange text-white" data-toggle="collapse" data-target="#id-{{$complete->id_order}}">Залишити відгук</button>
                                        </div>
                                        @endif
                                    </div>
                                    <div id="id-{{ $complete->id_order }}" class="container collapse bg-light-grey mt-4">
                                        <form method="POST" action="{{ route('save_review', $complete->id_order) }}" class="col">
                                            @csrf
                                            <div class="form-group row">
                                                <label for="rating" class="col-2">Оцінка:</label>
                                                <div class="col-3 rating">
                                                    <input type="range" id="rating" class="form-control reviews-rating" name="rating" min="1" max="5" step="0.5" value="3">
                                                </div>
                                                <div class="">
                                                    <span id="rating_val">3</span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="comment" class="col-1 col-form-label">Коментар:</label>
                                                <div class="col offset-1">
                                                    <textarea id="comment" class="form-control text-white border-0 bg-deep-dark reviews-comment" rows="3" name="text" required></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <button type="submit" class="col-3 offset-8 text-white btn badge-pill bg-green mb-2 px-0" name="leave_review">Підтвердити</button>
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
