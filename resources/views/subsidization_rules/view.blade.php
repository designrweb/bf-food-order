<?php
/**
 * @var array $resource
 */
?>
@extends('layouts.admin')

@section('content')
    <div id="grid-view-page">
        <grid-view :main_route="'/admin/subsidization-rules'" :id="{{$resource['id']}}"></grid-view>
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/subsidization_rules.js')}}"></script>
@stop
