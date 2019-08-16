@extends('layouts.site')

@section('header')
    @include('site.header')
@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="flash-message col-6">
            @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                @if(Session::has('alert-' . $msg))

                    <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                @endif
            @endforeach
        </div>
    </div>
    <div class="row">
        <form class="col-6" method="POST" action="{{ route('save_info') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Аватар:</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="avatar" id="avatar-input" lang="ua" accept="image/*" required>
                    <label class="custom-file-label" for="avatar-input" id="avatar-input-label" data-browse="Обрати">Виберіть файл</label>
                </div>
            </div>

            <div class="form-group row">
                <button type="submit" class="col text-white btn badge-pill bg-deep-blue  mb-2 px-0" name="form1">Підтвердити</button>
            </div>
        </form>
    </div>
    <div class="row">
        <form class="col-6" method="POST" action="{{ route('save_info') }}">
            @csrf
            <label>Профіль користувача</label>

            <div class="form-group">
                <label>Імя:</label>
                <div>
                    <input type="text" class="form-control" name="name" value="{{$data->name}}" required>
                </div>
            </div>
            <div class="form-group">
                <label>Прізвище:</label>
                <div>
                    <input type="text" class="form-control" name="surname" value="{{$data->surname}}" required>
                </div>
            </div>
            <div class="form-group">
                <label>По-батькові:</label>
                <div>
                    <input type="text" class="form-control" name="patronymic" value="{{$data->patronymic}}">
                </div>
            </div>
            <div class="form-group">
                <label>Дата народження:</label>
                <div>
                    <input type="date" class="form-control" name="birthday_date" value="{{$data->birthday_date}}">
                </div>
            </div>
            <div class="form-group">
                <label>Номер телефону:</label>
                <div>
                    <input type="text" class="form-control" name="phone_number" value="{{$data->phone_number}}">
                </div>
            </div>
            <div class="form-group">
                <label>Viber:</label>
                <div>
                    <input type="text" class="form-control" name="viber" value="{{$data->viber}}">
                </div>
            </div>
            <div class="form-group">
                <label>Skype:</label>
                <div>
                    <input type="text" class="form-control" name="skype" value="{{$data->skype}}">
                </div>
            </div>
            <div class="form-group">
                <label>Про мене:</label>
                <div>
                    <textarea class="form-control" rows="3" name="about_me">{{$data->about_me}}</textarea>
                </div>
            </div>
            <div class="form-group row">
                <button type="submit" class="col text-white btn badge-pill bg-deep-blue  mb-2 px-0" name="form2">Підтвердити</button>
            </div>
        </form>
    </div>
</div>



@endsection

@section('footer')
    @include('site.footer')
@endsection
