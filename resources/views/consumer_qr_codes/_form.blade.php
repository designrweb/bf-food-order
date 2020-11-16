<?php
/**
 * @var array $resource
 */
?>
@extends('layouts.admin')

@section('content')
    <div id="grid-form-page">
        @if(!empty($resource))
            <grid-form :main_route="'consumer-qr-codes'" :id="{{$resource['id']}}"></grid-form>
        @else
            <grid-form :main_route="'consumer-qr-codes'"></grid-form>
        @endif
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/consumer_qr_codes.js')}}"></script>
@stop

