@extends('layouts.site')

@section('header')
	@include('site.header')
@endsection

@section('content')
    <div>Admin panel</div>
    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">
        Logout
    </a>
    <form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>
@endsection

@section('footer')
    @include('site.footer')
@endsection