@extends('layouts.site')

@section('header')
    @include('site.header')
@endsection

@section('content')

<div class="container">
    <div class="row">
        <form action="" class="col">
            <div class="form-group row">
                <label for="title" class="col-3 col-form-label mt-2">Назва:</label>
                <div class="col-6 mt-2">
                    <input type="text" class="form-control" id="title" name="title">
                </div>
            </div>
            <div class="form-group row">
                <label for="description" class="col-3 col-form-label mt-2">Інормація:</label>
                <div class="col-6 mt-2">
                    <textarea name="description" id="description" cols="60" rows="3"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="price" class="col-3 col-form-label">Ціна:</label>
                <div class="col-6 mt-2">
                    <input type="number" id="price" class="form-control" name="price" required>
                </div>
                <select class="col-2 mt-2 px-0 form-control" name="currency">
                    <option>грн.</option>
                    <option>$</option>
                </select>
            </div>
            <div class="form-group row">
                <label for="time" class="col-3 col-form-label">Час:</label>
                <div class="col-6">
                    <input type="number" id="time" class="form-control" name="time" required>
                </div>
                <select class="col-2 px-0 form-control" name="type">
                    <option>дні</option>
                    <option>год.</option>
                </select>
            </div>
            <div class="form-group row">
                <button type="submit" class="col-3 text-white btn badge-pill bg-deep-blue  mb-2 px-0">Підтвердити</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('footer')
    @include('site.footer')
@endsection
