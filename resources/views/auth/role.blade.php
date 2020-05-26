@extends('layouts.site')


@section('content')

    <div class="text-white" id="password_change">
        <p class="col font-size-18 text-center">Оберіть свою роль</p>
        <form method="POST" action="{{ route('role-selected') }}" class="col-6 offset-3 shadow-lg pass_change pt-4 pb-2">
            @csrf
            <div class="col-12">
                <div class="form-group row">
                    <select id="id_role" class="form-control bg-light-black text-white border-0" name="id_role" size="2">
                        <option selected>Виконавець</option>
                        <option>Замовник</option>
                    </select>
                </div>

                <div class="form-group row justify-content-center">
                    <button type="submit" class="btn bg-green badge-pill text-white">
                        Підтвердити
                    </button>
                </div>
            </div>
        </form>
    </div>

@endsection

@section('footer')
    @include('site.footer')
@endsection
