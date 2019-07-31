@section('header')
    <div class="container-fluid bg-primary">
        <div class="row py-2 text-white text-center">
                <div class="col-1">
                    <div class="bg-success rounded-circle float-right" style="width: 2rem; height: 2rem">&nbsp;</div>
                </div>
                <div class="col-1 mt-1">
                    <a href="{{ route('home') }} " class="text-white">StudRISE</a>
                </div>
                <div class="col-7">
                    &nbsp;
                </div>
                <div class="col-1 mt-2 small">
                    <a href="{{ route('register') }}" class="text-white">Реєстрація</a>
                </div>
                <div class="col-1">
                    <div class="badge-pill bg-light my-1 mx-1">
                        <a href="{{ route('login') }}" class="text-dark small">Вхід</a>
                    </div>
                </div>
                <div class="col-1 mt-1">
                    UA
                </div>
        </div>
    </div>
@endsection
