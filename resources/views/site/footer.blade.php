@section('footer')
    <div class="container-fluid bg-deep-dark text-white border-top border-white">
        <div class="row">
            <div class="col-6 offset-1">
                <div>Спроектовано та розроблено</div>
                <div><img src="{{ asset('/StudCIT_LogoText.svg') }}" alt="StudCIT" height="50px"></div>
            </div>
            <div class="col-4 d-flex flex-row align-items-center">
                <div class="d-flex flex-grow-1">
                    <div>
                        <a href="studcit.sumdu.edu.ua" class="text-white">Наш сайт</a>
                    </div>
                    <div class="ml-auto">
                        <a href="mailto:s.panchenko@ias.sumdu.edu.ua" class="text-white">s.panchenko</a>
                    </div>
                </div>
            </div>
        </div>

        <!--
        <div class="row py-2 text-white">
            <div class="col-2 offset-1">
                <p class="text-capitalize">Загальна інформація</p>
                <hr style="border-color: white">
                    <a href="/" class="text-white">Головна</a><br>
                    <a>Про нас</a><br>
                    <a>Правила сайту</a>
            </div>
            <div class="col-2 offset-1">
                <p class="text-capitalize">Аккаунт</p>
                <hr style="border-color: white">
                <a href="{{ route('profile') }}" class="text-white">Мій аккаунт</a><br>
                <a href="{{ route('login') }}" class="text-white">Вхід</a>
            </div>
            <div class="col-2 offset-1">
                <p class="text-capitalize">Соціальні мережі</p>
                <hr style="border-color: white">
                <a>Facebook</a><br>
                <a>Twitter</a><br>
                <a>Instagram</a>
            </div>
            <div class="col-2 offset-1">
                <p class="text-capitalize">Розробка</p>
                <hr style="border-color: white">
                <a>Студентський центр інформаційних технологій</a><br>
                <a href="mailto:s.panchenko@ias.sumdu.edu.ua" class="text-white">s.panchenko</a>
            </div>
        </div>-->
    </div>
@endsection
