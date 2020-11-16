<?php
/**
 * @var array $resource
 */
?>
@extends('layouts.admin')

@section('content')
    <div id="grid-form-page">
        @if(!empty($resource))
            <grid-form :main_route="'consumer-auto-orders'" :id="{{$resource['id']}}"></grid-form>
        @else
            <grid-form :main_route="'consumer-auto-orders'"></grid-form>
        @endif
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/consumer_auto_orders.js')}}"></script>
@stop

