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
    <div class="collapse user_block show" id="profile-info">
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
                @if(Auth::check() && $data->id_user != Auth::id())
                    <form method="POST" action="{{ route('new_contact') }}" class="px-0">
                        @csrf
                        <button type="submit" class="btn bg-blue text-white font-weight-bold font-size-25" name="id_user" value="{{ $data->id_user }}">Відкрити приватний чат</button>
                    </form>
                @elseif(Auth::check())
                    &nbsp;<button class="btn bg-orange text-white font-weight-bold font-size-25" data-toggle="collapse" data-target=".user_block">Редагувати профіль</button>
                @endif
            </div>
        </div>
    </div>
    <div class="collapse user_block" id="profile-edit">
        <div class="d-flex flex-row align-items-center bg-light-black">
            <div class="col-2 offset-1 px-0 my-2">
                <img src="{{ $data->avatar }}" class="circle avatar" style="height: 260px; width: 260px">
            </div>
            <div class="col-6 text-white">
                <form method="POST" action="{{ route('save_info') }}" class="col-10 offset-1 shadow-lg offset-1" id="save_info" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row mt-4">
                        <label class="col-5 col-form-label mt-2">Аватар:</label>
                        <div class="custom-file col-6 mt-2">
                            <input type="file" class="custom-file-input form-control border-0" name="avatar" id="avatar-input" lang="ua" accept="image/*">
                            <label class="custom-file-label bg-deep-dark text-white border-0 nowrap" for="avatar-input" id="avatar-input-label" data-browse="Обрати">Виберіть файл</label>
                            <div class="invalid-feedback">Зображення більше 2 Мб</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="surname" class="col-5 col-form-label mt-2">Прізвище:</label>
                        <div class="col-6 mt-2">
                            <input type="text" id="surname" class="form-control bg-deep-dark text-white border-0" name="surname" value="{{ $data->surname }}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-5 col-form-label mt-2">Ім'я:</label>
                        <div class="col-6 mt-2">
                            <input type="text" id="name" class="form-control bg-deep-dark text-white border-0" name="name" value="{{ $data->name }}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="about_me" class="col-5 col-form-label mt-2">Про мене:</label>
                        <div class="col-6 mt-2">
                            <textarea class="form-control bg-deep-dark text-white border-0" id="about_me" name="about_me" rows="6">{{ $data->about_me }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <a href="{{ route('password_change') }}" class="btn text-white font-weight-bold mb-4 mx-auto pointer">Змінити пароль</a>
                    </div>
                </form>
            </div>
            <div class="col-2 d-flex flex-row">
                @if($data->id_user != Auth::id())
                    <form method="POST" action="{{ route('new_contact') }}" class="px-0">
                        @csrf
                        <button type="submit" class="btn bg-blue text-white font-weight-bold font-size-25" name="id_user" value="{{ $data->id_user }}">Відкрити приватний чат</button>
                    </form>
                @else
                    &nbsp;<button class="btn bg-green text-white font-weight-bold font-size-25" onclick="$('#save_info').submit()">Зберегти</button>
                    &nbsp;<button class="btn text-white font-weight-bold font-size-25" data-toggle="collapse" data-target=".user_block">X</button>
                @endif
            </div>
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
                    <div class="font-size-25">Активні проєкти</div>
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
                                <button class="btn work-order bg-orange text-white" data-id="{{ $all->id_order }}">Переглянути</button>
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
    <div class="collapse container mt-4" id="active-w">
        <div class="text-white">
            <div class="d-flex justify-content-center">
                <p class="font-size-30 font-weight-bold">Активні проєкти</p>
            </div>
            @php($i = 0)
            @foreach($proposals as $active)
                @if($active->status == 'in progress')
                    @php($i++)
                    <div class="container shadow-box mb-4 orders">
                        <div class="d-flex flex-row justify-content-between align-items-center">
                            <div class="d-flex justify-content-start">
                                <div class="d-flex flex-row">
                                    <div class="font-weight-bold order-title font-size-30">{{ $active->title }}</div>
                                </div>
                            </div>
                            <div class="text-center font-weight-bold font-size-30 nowrap justify-content-end">{{ $active->price }}</div>
                        </div>
                        <div class="text-grey">{{ $active->created_at }}</div>
                        <div class="d-flex flex-row justify-content-between">
                            <div class="d-flex justify-content-start align-items-center">
                                <div class="font-size-22">{{ $active->description }}</div>
                            </div>
                            <div class="d-flex flex-column justify-content-end">
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
    <div class="collapse container mt-4" id="complete-w">
        <div class="text-white">
            <div class="d-flex justify-content-center">
                <p class="font-size-30 font-weight-bold">Завершені проєкти</p>
            </div>
            @php($i = 0)
            @foreach($proposals as $complete)
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
                                <div class="font-size-20">Замовник:
                                    <span class="to-profile pointer" data-id=""></span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button class="btn bg-orange text-white" data-toggle="collapse" data-target="#id-{{$complete->id_proposal}}">Залишити відгук</button>
                            </div>
                        </div>
                        <div id="id-{{ $complete->id_proposal }}" class="container collapse bg-light-grey mt-4">
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
    @if(count($reviews) != 0)
        <div class="d-flex justify-content-center my-4">
            <button class="btn badge-pill bg-orange text-center text-white" id="mark-toggle" data-toggle="collapse" data-target="#mark" aria-expanded="true">Відобразити відгуки</button>
        </div>
    <div class="collapse" id="mark">
        <div class="offset-1 col-10">
            <div class="row">
            @foreach($reviews as $mark)
                <div class="col-6 bg-deep-dark text-white shadow-box mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex flex-row align-items-center mt-2">
                            <div class="px-0 pointer to-profile" data-id="{{ $mark->id_user }}">
                                <img src="{{ $mark->avatar }}" class="circle avatar" style="height: 106px; width: 106px">
                            </div>
                            <div class="pointer to-profile font-size-30 ml-2" data-id="{{ $mark->id_user }}">{{ $mark->name }} {{ $mark->surname }}</div>
                        </div>
                    </div>
                    <hr class="border-grey">
                    <div class="d-flex flex-row justify-content-between mb-4">
                        <div class="mt-2 align-self-center">{{ $mark->text }}</div>
                        <div class="d-flex flex-column">
                            <div>
                                <div class="font-size-30">{{ $mark->rating }}/5</div>
                            </div>
                            <div class="d-flex">
                                <div class="font-size-10">{{ $mark->created_at }}</div>
                            </div>
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
