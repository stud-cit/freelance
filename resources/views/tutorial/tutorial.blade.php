<!doctype html>
<html class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>WorkDump</title>

    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/png">
<!--<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">-->
<!--<link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css">-->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/tutorial.css') }}" rel="stylesheet" type="text/css">

</head>
<body class="d-flex flex-column h-100">
<!--Header_section-->
<header id="header_wrapper">
</header>
<!--Header_section-->

<!--Main_Section-->

@yield('content')

<div id="tutorial_start" class=" tutorial-layout">
    <img src="bg-tutor.png" alt="" class="tutorial-bg-image">
    <img src="logo-tutor.png" class="tutorial-logo" alt="">
    <div class="scroll-down">
        <div class="d-md-none text-primary scroll-mobile ">
            <p>Прочитати керівництво</p>
            {{--<div class="text-center">	&#11167;</div>--}}
            {{--<div class="text-center">	&#11167;</div>--}}
            {{--<div class="text-center">	&#11167;</div>--}}
        </div>
        <div class="d-none d-md-block ">
            <p>Гортайте вниз щоб прочитати керівництво</p>
            <div class="dots">
                <img src="dots.png" alt="">
                <div class="dots-bg"></div>
            </div>
        </div>

    </div>
    <a href="/orders" class="skip">Пропустити</a>
</div>
<div id="tutorial_main" >
    <ul class="tutorial-list">
        <li class="tutorial-item active">
            <span class="num active">1</span>
            <h2>Зареєструйтеся</h2>
            <p>
                Натисніть на кнопку <span class="badge-pill bg-orange py-1 px-4 text-white">Вхід</span> у верхньому правому кутку.
                У відкрившомуся вікні натисніть <span class="text-primary" style="text-decoration: underline">Залишити заяву</span>.
                Заповніть форму відповідно, обравши Вашу роль на ресурсі (Замовник для створення замовлень на виконання робіт або Виконавець для виконання наявних замовлень)
                та натисніть  <span class="badge-pill bg-green py-1 text-white">Відправити</span>.
                Дочекайтеся відповіді на вказану електронну пошту. Ви маєте отримати дані для входу на ресурс.
                Використовуйте їх для входу на ресурс на сторінці входу у формі справа.
            </p>
        </li>
        <li class="tutorial-item">
            <span class="num">2</span>
            <h2>Залишайте заяви та пропозиції</h2>
            <p>
                Якщо Ви Замовник:<br>
                Натисніть <span class="text-white text-center font-weight-bold bg-green px-0" style="display: inline-block; width:54px; height: 54px; border-radius: 50%; font-size: 25pt">&#43;</span>
                щоб відкрити форму створення замовлення. Заповнуть форму вказавши необхідні дані, строки та вартісь за необхідністю.
                <br>
                Якщо Ви виконавець:<br>
                Знайдіть замовлення, що Вас цікавить на головній сторінці.
                Натисніть <span class="btn bg-orange text-white">Переглянути</span> та ознайомтеся детальніше.
                Якщо ви бажаєте виконати замовлення натисніть <span class="btn text-white" style="background-color: #2D3A4D">&#8595;&nbsp;Залишити пропозицію&nbsp;&#8595;</span>
                та заповніть форму пропозиції, за необхідністю запропонуйте свої строки та вартість та поясніть чим обумовлені зміни.
            </p>
        </li>
        <li class="tutorial-item">
            <span class="num">3</span>
            <h2>Співпрацюйте</h2>
            <p>
                Отримуйте інформацію щодо ваших замовлень або пропозиційна пошту або безпосередньо на сайті. Домовляйтеся з іншими користувачами, виконуйте та приймайте роботу.
                Користуйтеся кнопками <span class="btn bg-primary rounded-pill text-white">Зв'язатися</span> та <span class="btn text-white" style="background-color: #2D3A4D">Чат</span>
                для вирішення різноманітних питань.
            </p>
        </li>
        <li class="tutorial-item">
            <span class="num">4</span>
            <h2>Продовжуйте</h2>
            <p>
                Після виконання замовлення Виконавцем Замовник може завершити проєкт та написати відгук Виконавцю. Продовжуйте створювати та виконувати проєкти разом з нами.
            </p>
        </li>
        <a href="/orders" class="skip">Зрозуміло, перейти на сайт</a>
        <img src="dump-logo.svg" alt="" class="dump-logo">
    </ul>
</div>

<!--Footer_section-->

<!--Footer_section-->

<!--Modal_loader-->
<div class="modal" id="load" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
    <div class="spinner-border text-white position-absolute m-auto" role="status" style="top: 0; left: 0; bottom: 0; right: 0;">
        <span class="sr-only">Loading...</span>
    </div>
</div>


<!--<script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>-->
<script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/tutorial.js') }}"></script>


</body>
</html>
