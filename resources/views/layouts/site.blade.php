<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, maximum-scale=1">
<title>freelance</title>

<link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">




</head>
<body>
<!--Header_section-->
<header id="header_wrapper">
	@yield('header')
</header>
<!--Header_section-->

<!--Main_Section-->

	@yield('content')


<script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('app.js') }}"></script>


</body>
</html>
