@section('footer')
    <div class="container-fluid bg-black text-white">
        <div class="row">
            <div class="col-6 offset-1">
                <div>Спроєктовано та розроблено</div>
                <div><img src="{{ asset('/StudCIT_LogoText.svg') }}" alt="StudCIT" height="50px"></div>
            </div>
            <div class="col-4 d-flex flex-md-row flex-column align-items-md-center">
                <div class="d-flex flex-md-row flex-column flex-grow-1">
                    <div class="mr-md-auto">
                        <a href="{{ route('tutorial') }}" class="text-white">Туторіал</a>
                    </div>
                    <div>
                        <a href="http://studcit.obdev.sumdu.edu.ua/" class="text-white">Наш сайт</a>
                    </div>
                    <div class="ml-md-auto">
                        <a href="mailto:s.panchenko@ias.sumdu.edu.ua" class="text-white">s.panchenko</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
