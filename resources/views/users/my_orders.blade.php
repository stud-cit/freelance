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
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-new-tab" data-toggle="tab" href="#nav-new" role="tab" aria-controls="nav-new" aria-selected="true">Відкриті проєкти</a>
                    <a class="nav-item nav-link" id="nav-progress-tab" data-toggle="tab" href="#nav-progress" role="tab" aria-controls="nav-progress" aria-selected="false">Проєкти у процесі</a>
                    <a class="nav-item nav-link" id="nav-complete-tab" data-toggle="tab" href="#nav-complete" role="tab" aria-controls="nav-complete" aria-selected="false">Завершені проєкти</a>
                </div>
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
                                                    <button class="btn border-grey">
                                                        <span class="text-grey">{{ $tags->name }}</span>
                                                    </button>
                                                @endforeach
                                            </div>
                                            @if(!is_null($all->dept))
                                                <div class="text-left float-left text-grey font-size-20 ml-2">{{ $all->dept->name }}</div>
                                            @endif
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
                                    <div class="font-size-22">{{ $active->description }}</div>
                                    <div class="d-flex flex-row justify-content-between">
                                        <div class="d-flex justify-content-start align-items-center">
                                            <div class="tag-list">
                                                @foreach($active->categories as $tags)
                                                    <button class="btn border-grey">
                                                        <span class="text-grey">{{ $tags->name }}</span>
                                                    </button>
                                                @endforeach
                                            </div>
                                            @if(!is_null($active->dept))
                                                <div class="text-left float-left text-grey font-size-20 ml-2">{{ $active->dept->name }}</div>
                                            @endif
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
                                            <div class="font-size-20">Виконавкць:
                                                <span class="to-profile pointer" data-id="{{ $complete->id_worker }}">{{ $complete->worker->name }} {{ $complete->worker->surname }}</span>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <button class="btn work-order bg-orange text-white" style="display: none" data-id="{{ $complete->id_order }}">Залишити відгук</button>
                                        </div>
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
