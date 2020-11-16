<?php
/**
 * @var array $resource
 */
?>
@extends('layouts.admin')

@section('content')
    <div id="grid-form-page">
        @if(!empty($resource))
            <grid-form :main_route="'orders'" :id="{{$resource['id']}}"></grid-form>
        @else
            <grid-form :main_route="'orders'"></grid-form>
        @endif
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/orders.js')}}"></script>
@stop

