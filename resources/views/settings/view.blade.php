<?php
/**
 * @var array $resource
 */
?>
@extends('layouts.admin')

@section('content')
    <div id="grid-view-page">
        <grid-view :main_route="'/admin/settings'" :id="{{$resource['id']}}"></grid-view>
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/settings.js')}}"></script>
@stop
