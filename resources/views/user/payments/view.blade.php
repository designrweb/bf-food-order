<?php
/**
 * @var array $resource
 */
?>
@extends('layouts.admin')

@section('content')
    <div id="grid-view-page">
        <grid-view :main_route="'/user/payments'" :id="{{$resource['id']}}"></grid-view>
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/user_payments.js')}}"></script>
@stop
