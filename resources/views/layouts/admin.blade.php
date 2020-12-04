@extends('adminlte::page')

@section('title', 'Laravel App')

@section('adminlte_css_pre')
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
@stop

@section('js')
    <script src="{{('/js/app.js')}}"></script>
@stop
