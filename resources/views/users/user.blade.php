@extends('layouts.site')

@section('header')
    @include('site.header')
@endsection

@section('content')

@php($data = $info['data'])
@php($reviews = $info['reviews'])
@php($dept = $info['dept'])
@php($active = $info['active'])
@php($complete = $info['complete'])
@php($orders = $info['orders'])
@php($proposals = $info['proposals'])
@php($progress = $info['progress'])

<div>
    <div class="flash-message fixed-bottom text-center">
        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
            @if(Session::has('alert-' . $msg))
                <p class="alert alert-{{ $msg }} alert-dismissible"> {{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
            @endif
        @endforeach
    </div>
    <div class="d-flex flex-row align-items-center bg-light-black">
        <div class="col-2 offset-1 px-0 my-2">
            <img src="{{ $data->avatar }}" class="circle avatar" style="height: 260px; width: 260px">
        </div>
        <div class="col-6 text-white">
            <div class="col-12 name surname font-weight-bold font-size-50">{{ $data->name }} {{ $data->surname }}</div>
            @if(!is_null($dept))
                <div class="col-12 font-weight-bold font-size-35">{{ $dept->name }}</div>
            @endif
            <div class="col-12 font-size-35">
                @foreach($data->categories as $tags)
                    <span class="tags">{{ $tags->name }}</span>
                @endforeach
            </div>
            @if(!is_null($data->about_me))
                <div class="col-12 text-gray font-size-20">{{ $data->about_me }}</div>
            @endif
        </div>
        <div class="col-2">
            @if($data->id_user != Auth::id())
                <form method="POST" action="{{ route('new_contact') }}" class="px-0">
                    @csrf
                    <button type="submit" class="btn bg-blue text-white font-weight-bold font-size-25" name="id_user" value="{{ $data->id_user }}">Відкрити приватний чат</button>
                </form>
            @else
                &nbsp;<!--<button class="btn bg-orange text-white font-weight-bold font-size-25">Редагувати профіль</button>-->
            @endif
        </div>
    </div>
    <div class="col-12">
        <div class="d-flex flex-row justify-content-around mt-5 text-white text-center">
            @if($data->id_role == 2)
                <div class="pointer change" id="new-c-toggle" data-toggle="collapse" data-target="#new-c" aria-expanded="false">
                    <div class="font-size-100">{{ $active }}</div>
                    <div class="font-size-25">Відкриті проєкти</div>
                </div>
                <div class="pointer change" id="progress-c-toggle" data-toggle="collapse" data-target="#progress-c" aria-expanded="false">
                    <div class="font-size-100">{{ $progress }}</div>
                    <div class="font-size-25">Активні проєкти</div>
                </div>
                <div class="pointer change" id="complete-c-toggle" data-toggle="collapse" data-target="#complete-c" aria-expanded="false">
                    <div class="font-size-100">{{ $complete }}</div>
                    <div class="font-size-25">Завершені проєкти</div>
                </div>
            @elseif($data->id_role == 3)
                <div class="pointer change" id="new-w-toggle" data-toggle="collapse" data-target="#new-w" aria-expanded="false">
                    <div class="font-size-100">{{ $active }}</div>
                    <div class="font-size-25">Залишені пропозиції</div>
                </div>
                <div class="pointer change" id="active-w-toggle" data-toggle="collapse" data-target="#active-w" aria-expanded="false">
                    <div class="font-size-100">{{ $progress }}</div>
                    <div class="font-size-25">Активн проєкти</div>
                </div>
                <div class="pointer change" id="complete-c-toggle" data-toggle="collapse" data-target="#complete-w" aria-expanded="false">
                    <div class="font-size-100">{{ $complete }}</div>
                    <div class="font-size-25">Завершені проєкти</div>
                </div>
            @endif
        </div>
        <div class="collapse container mt-4" id="new-c">
            <div class="text-white">
                <div class="d-flex justify-content-center">
                    <p class="font-size-30 font-weight-bold">Відкриті проєкти</p>
                </div>
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
                                    <button class="btn work-order bg-orange" data-id="{{ $all->id_order }}">Переглянути</button>
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
        <div class="collapse container mt-4" id="progress-c">
            <div class="text-white">
                <div class="d-flex justify-content-center">
                    <p class="font-size-30 font-weight-bold">Проєкти у процесі</p>
                </div>
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
                                    <button class="btn work-order bg-orange" data-id="{{ $active->id_order }}">Переглянути</button>
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
        <div class="collapse container mt-4" id="complete-c">
            <div class="text-white">
                <div class="d-flex justify-content-center">
                    <p class="font-size-30 font-weight-bold">Завершені проєкти</p>
                </div>
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
                                    <button class="btn work-order bg-orange" style="display: none" data-id="{{ $complete->id_order }}">Залишити відгук</button>
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
    <div class="collapse container mt-4" id="new-w">
        <div class="text-white">
            <div class="d-flex justify-content-center">
                <p class="font-size-30 font-weight-bold">Залишені пропозиції</p>
            </div>
            @php($i = 0)
            @foreach($proposals as $all)
                @if($all->status == 'new')
                    @php($i++)
                    <div class="container shadow-box mb-4 orders">
                        <div class="d-flex flex-row justify-content-between align-items-center">
                            <div class="d-flex justify-content-start">
                                <div class="d-flex flex-row">
                                    <div class="font-weight-bold order-title font-size-30">{{ $all->title }}</div>
                                </div>
                            </div>
                            <div class="text-center font-weight-bold font-size-30 nowrap justify-content-end">{{ $all->price }}</div>
                        </div>
                        <div class="text-grey">{{ $all->created_at }}</div>
                        <div class="d-flex flex-row justify-content-between">
                            <div class="d-flex justify-content-start align-items-center">
                                <div class="font-size-22">{{ $all->description }}</div>
                            </div>
                            <div class="d-flex flex-column justify-content-end">
                                <button class="btn work-order bg-orange" data-id="{{ $all->id_order }}">Переглянути</button>
                                @if($all->id_worker == Auth::id())
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
                    <div class="font-size-30 font-weight-bold">Немає залишених пропозицій</div>
                </div>
            @endif
        </div>
        <hr class="border-white w-100">
    </div>
    @if(count($reviews) != 0)
        <div class="d-flex justify-content-center my-4">
            <button class="btn badge-pill bg-orange text-center text-white" id="mark-toggle" data-toggle="collapse" data-target="#mark" aria-expanded="true">Відобразити відгуки</button>
        </div>
    <div class="collapse" id="mark">
        <div class="offset-1 col-10">
            <div class="row">
            @foreach($reviews as $mark)
                <div class="col-6 bg-deep-dark text-white">
                    <div class="d-flex flex-row align-items-center">
                        <div class="col-2 px-0 pointer to-profile" data-id="{{ $mark->id_user }}">
                            <img src="{{ $mark->avatar }}" class="circle avatar" style="height: 106px; width: 106px">
                        </div>
                        <div class="col-10 pointer to-profile" data-id="{{ $mark->id_user }}">{{ $mark->name }} {{ $mark->surname }}</div>
                    </div>
                    <div class="d-flex flex-row mb-4">
                        <div class="col-10 mt-2">{{ $mark->text }}</div>
                        <div class="col-2">
                            <div>
                                <img src="" alt="">
                            </div>
                            <div class="font-size-10">{{ $mark->created_at }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
            {{ $reviews->links('layouts.pagination') }}
            </div>
        </div>
    </div>
    @endif
</div>


@endsection

@section('footer')
    @include('site.footer')
@endsection
