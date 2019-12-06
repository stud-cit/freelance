@section('footer')
    <div class="container-fluid bg-black text-white">
        <div class="row">
            <div class="col-6 offset-1">
                <div>Спроєктовано та розроблено</div>
                <div><img src="{{ asset('/StudCIT_LogoText.svg') }}" alt="StudCIT" height="50px"></div>
            </div>
            <div class="col-4 d-flex flex-row align-items-center">
                <div class="d-flex flex-grow-1">
                    <div class="mr-auto">
                        <a href="{{ route('orders') }}" class="text-white">Туторіал</a>
                    </div>
                    <div>
                        <a href="http://studcit.obdev.sumdu.edu.ua/" class="text-white">Наш сайт</a>
                    </div>
                    <div class="ml-auto">
                        <a href="mailto:s.panchenko@ias.sumdu.edu.ua" class="text-white">s.panchenko</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
