<?php
/**
 * @var array $resource
 */
?>
@extends('layouts.admin')

@section('content')
    <div id="grid-form-page">
        @if(!empty($resource))
            <grid-form
                :main_route="'/admin/payments'"
                :id="{{$resource['id']}}"
                :consumers_list="{{json_encode($resource['consumersList'])}}"
            ></grid-form>
        @else
            <grid-form
                :main_route="'/admin/payments'"
                :consumers_list="{{json_encode($consumersList)}}"
            ></grid-form>
        @endif
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/payments.js')}}"></script>
@stop

