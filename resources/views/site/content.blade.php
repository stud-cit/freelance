@extends('layouts.site')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-11 offset-1">
                <h1>Хочете розпочати свій кар'єрний шлях вже сьогодні?</h1>
                <p class="mt-2 col-5">Шукайте гарного спеціаліста або самі бажаєте стати фрілансером, але не знаєте з чого почати? Зареєструйся та почни виконувати своє перше замовлення вже сьогодні!</p>
                <ul>
                    <li>Швидка реєстрація</li>
                    <li>Великий вибір напрямку</li>
                    <li>Зручний та зрозумілий інтерфейс</li>
                    <li>Гарантована надійність</li>
                </ul>
                <a href="{{ route('register') }}" class="offset-1 badge-pill btn bg-violet text-white">Реєстрація</a>
            </div>
        </div>
        <div class="row">
            <div class="col-11 offset-1">
                <h1 class="col-6">Що потрібно саме тобі?</h1>
                <p>Шукайте гарного спеціаліста або самі бажаєте стати фрілансером, але не знаєте з чого почати? Зареєструйся та почни виконувати своє перше замовлення вже сьогодні!</p>
            </div>
            <div class="col-5 offset-1 text-center">
                <div class="shadow p-2">
                    <h2>Виконавець</h2>
                    <p>Фрілансери перетворять ваші  ідеї в реальність!</p>
                    <p >Шукайте гарного спеціаліста або самі бажаєте стати фрілансером, але не знаєте з чого почати? Зареєструйся та почни виконувати своє перше замовлення вже сьогодні!</p>
                </div>
            </div>
            <div class="col-5 text-center">
                <div class="bg-blue p-2">
                    <h2>Замовник</h2>
                    <p>Фрілансери перетворять ваші  ідеї в реальність!</p>
                    <p>Шукайте гарного спеціаліста або самі бажаєте стати фрілансером, але не знаєте з чого почати? Зареєструйся та почни виконувати своє перше замовлення вже сьогодні!</p>
                </div>
            </div>
        </div>
        <div class="row bg-blue text-white mt-2">
            <div class="col-3">img</div>
            <div class="col-6 offset-1 text-center">
                <p>Шукайте гарного спеціаліста або самі бажаєте стати фрілансером, але не знаєте з чого почати? Зареєструйся та почни виконувати своє перше замовлення вже сьогодні!</p>
                <a href="{{ route('register') }}" class="badge-pill btn bg-violet text-white">Реєстрація</a>
                <a href="{{ route('login') }}" class="badge-pill btn btn-outline-light">Вхід в акаунт</a>
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-right">
                <h1>Чому саме ми?</h1>
                <p>Шукайте гарного спеціаліста або самі бажаєте стати фрілансером, але не знаєте з чого почати?<br>Зареєструйся та почни виконувати своє перше замовлення вже сьогодні!</p>
            </div>
        </div>
        <div class="row">
            <div class="offset-1 col-5 bg-blue">
                <h2>Lorem ipsum dolor</h2>
                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing eliffneu,  pretium quis ipsum dolor sit amet, consectetuer adipiscing eliffneu,  pretium quis </p>
            </div>
            <div class="col-5">
                <h2>Lorem ipsum dolor</h2>
                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing eliffneu,  pretium quis ipsum dolor sit amet, consectetuer adipiscing eliffneu,  pretium quis </p>
            </div>
        </div>
        <div class="row">
            <div class="offset-1 col-5">
                <h2>Lorem ipsum dolor</h2>
                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing eliffneu,  pretium quis ipsum dolor sit amet, consectetuer adipiscing eliffneu,  pretium quis </p>
            </div>
            <div class="col-5">
                <h2>Lorem ipsum dolor</h2>
                <p>Lorem ipsum dolor sit amet, consectetuer adipiscing eliffneu,  pretium quis ipsum dolor sit amet, consectetuer adipiscing eliffneu,  pretium quis </p>
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-center">
                <h1>Всього декілька кроків!</h1>
                <p class="col-6 offset-3">Шукайте гарного спеціаліста або самі бажаєте стати фрілансером, але не знаєте з чого почати? Зареєструйся та почни виконувати своє перше замовлення вже сьогодні!</p>
            </div>
        </div>
        <div class="row text-center">
            <div class="col-4">
                <img src="/public/login.jpg">
                <h3 class="font-weight-bold">Lorem ipsum dolor</h3>
                <p>Шукайте гарного спеціаліста або самі бажаєте стати фрілансером, але не знаєте з чого почати? Зареєструйся та почни виконувати своє перше замовлення вже сьогодні!</p>
            </div>
            <div class="col-4">
                <img src="/public/login.jpg">
                <h3 class="font-weight-bold">Lorem ipsum dolor</h3>
                <p>Шукайте гарного спеціаліста або самі бажаєте стати фрілансером, але не знаєте з чого почати? Зареєструйся та почни виконувати своє перше замовлення вже сьогодні!</p>
            </div>
            <div class="col-4">
                <img src="/public/login.jpg">
                <h3 class="font-weight-bold">Lorem ipsum dolor</h3>
                <p>Шукайте гарного спеціаліста або самі бажаєте стати фрілансером, але не знаєте з чого почати? Зареєструйся та почни виконувати своє перше замовлення вже сьогодні!</p>
            </div>
        </div>
        <div class="row">
            <div class="col-11 offset-1">
                <h1>Інформація про НАС</h1>
            </div>
            <div class="col-11 offset-1 bg-blue">
                <p>Шукайте гарного спеціаліста або самі бажаєте стати фрілансером, але не знаєте з чого почати? Зареєструйся та почни виконувати своє перше замовлення вже сьогодні!</p>
                <p>Шукайте гарного спеціаліста або самі бажаєте стати фрілансером, але не знаєте з чого почати? Зареєструйся та почни виконувати своє перше замовлення вже сьогодні!</p>
                <p>Шукайте гарного спеціаліста або самі бажаєте стати фрілансером, але не знаєте з чого почати? Зареєструйся та почни виконувати своє перше замовлення вже сьогодні!</p>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-12 text-center">
                <h1>Лови момент!</h1>
                <p>Реєстрація</p>
            </div>
        </div>
        <div class="row">
            <a href="{{ route('register') }}" class="offset-5 col-2 btn badge-pill bg-violet text-white">Реєстрація</a>
        </div>
    </div>
@endsection
<!--
<div class="flex-center position-ref full-height">
    @if (Route::has('login'))
        <div class="top-right links">
            @auth
                <a href="{{ url('/admin') }}">Home</a>
            @else
                <a href="{{ route('login') }}">Login</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Register</a>
                @endif
            @endauth
        </div>
    @endif

</div>
-->
