<?php
/**
 * @var array $resource
 */
?>

@extends('layouts.admin')

@section('content')
    <div id="grid-view-page">
        <grid-view
                :main_route="'/admin/catering-items'"
                title="{{$resource['name']}}"
                :id="{{$resource['id']}}"
        ></grid-view>
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/catering_items.js')}}"></script>
@stop
