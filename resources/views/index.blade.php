@extends('layouts.frontend')

@section('title', 'Frontend Page')

@section('content')
    <div class="h-100">
        <div class="w-100 p-4 text-right links">
            <a target="_blank" href="/admin">Admin page</a>
        </div>
        <div class="mt-5">
            <div class="w-100">
                <div class="title m-b-md text-center">
                    Bigfood Laravel Template
                </div>
            </div>
            <div class="w-100">
                <div class="d-flex justify-content-center links">
                    <a target="_blank" href="https://laravel.com/docs">Docs</a>
                    <a target="_blank" href="https://github.com/jeroennoten/Laravel-AdminLTE/">AdminLTE</a>
                    <a target="_blank" href="https://github.com/andriyburda/crud-generator/blob/master/readme.md">CRUD Generator</a>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
@stop

@section('js')
@stop
