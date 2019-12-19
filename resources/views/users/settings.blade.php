@extends('layouts.site')

@section('header')
    @include('site.header')
@endsection

@section('content')

@php($categories = $data['categories'])
@php($dept = $data['dept'])
@php($types = $data['types'])


@endsection

@section('footer')
    @include('site.footer')
@endsection
