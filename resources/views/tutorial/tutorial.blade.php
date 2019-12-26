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
        <p>Scroll down to view tutorial</p>
        <div class="dots">
            <img src="dots.png" alt="">
            <div class="dots-bg"></div>
        </div>

    </div>
    <a href="/orders" class="skip">Skip tutorial</a>
</div>
<div id="tutorial_main" >
    <ul class="tutorial-list">
        <li class="tutorial-item active">
            <span class="num active">1</span>
            <h2>Register your account</h2>
            <p>
                Description of the step Description of the step Description of the
                step Description of the step Description of the step Description of
                the step Description of the step Description of the step
                Description of the step Description of the step.
            </p>
        </li>
        <li class="tutorial-item">
            <span class="num">2</span>
            <h2>Register your account</h2>
            <p>
                Description of the step Description of the step Description of the
                step Description of the step Description of the step Description of
                the step Description of the step Description of the step
                Description of the step Description of the step.
            </p>
        </li>
        <li class="tutorial-item">
            <span class="num">3</span>
            <h2>Register your account</h2>
            <p>
                Description of the step Description of the step Description of the
                step Description of the step Description of the step Description of
                the step Description of the step Description of the step
                Description of the step Description of the step.
            </p>
        </li>
        <li class="tutorial-item">
            <span class="num">4</span>
            <h2>Register your account</h2>
            <p>
                Description of the step Description of the step Description of the
                step Description of the step Description of the step Description of
                the step Description of the step Description of the step
                Description of the step Description of the step.
            </p>
        </li>
        <a href="/orders" class="skip">I got it. Visit site</a>
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
