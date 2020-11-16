<?php
/**
 * @var array $resource
 */
?>
@extends('layouts.admin')

@section('content')
    <div id="grid-view-page">
        <grid-view :main_route="'consumer-qr-codes'" :id="{{$resource['id']}}"></grid-view>
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/consumer_qr_codes.js')}}"></script>
@stop
