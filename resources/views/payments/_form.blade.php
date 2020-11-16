<?php
/**
 * @var array $resource
 */
?>
@extends('layouts.admin')

@section('content')
    <div id="grid-form-page">
        @if(!empty($resource))
            <grid-form :main_route="'payments'" :id="{{$resource['id']}}"></grid-form>
        @else
            <grid-form :main_route="'payments'"></grid-form>
        @endif
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/payments.js')}}"></script>
@stop

