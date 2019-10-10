@section('footer')
    <div class="container-fluid bg-secondary text-white">
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
        </div>
    </div>
@endsection
