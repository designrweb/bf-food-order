@extends('layouts.admin')

@section('title', 'Admin template')

@section('content')
    <div class="position-relative h-100">
        <div class="d-flex justify-content-center">
            <div class="admin-text">Admin part</div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .admin-text {
            color: #636b6f;
            padding: 0 25px;
            font-size: 23px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }
    </style>
@stop
