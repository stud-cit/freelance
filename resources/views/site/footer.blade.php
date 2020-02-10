@section('footer')
    <div class="container-fluid bg-black text-white">
        <div class="row">
            <div class="d-flex flex-column col-6 offset-1 justify-content-center my-md-0 my-2">
                <div>Спроєктовано та розроблено</div>
                <div class="d-sm-none d-flex font-italic font-size-22">StudCIT</div>
                <div class="d-sm-flex d-none"><img src="{{ asset('/StudCIT_LogoText.svg') }}" alt="StudCIT" height="50px"></div>
            </div>
            <div class="col-4 d-flex flex-md-row flex-column align-items-md-center">
                <div class="d-flex flex-md-row flex-column flex-grow-1">
                    <div class="mr-md-auto text-right my-md-0 my-2">
                        <a href="{{ route('tutorial') }}" class="text-white">Туторіал</a>
                    </div>
                    <div class="text-right my-md-0 my-2">
                        <a href="http://studcit.obdev.sumdu.edu.ua/" class="text-white">Наш сайт</a>
                    </div>
                    <div class="ml-md-auto text-right my-md-0 my-2">
                        <a href="mailto:s.panchenko@ias.sumdu.edu.ua" class="text-white">s.panchenko</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
