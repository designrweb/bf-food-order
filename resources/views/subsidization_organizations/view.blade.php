<?php
/**
 * @var array $resource
 */
?>
@extends('layouts.admin')

@section('content')
    <div id="grid-view-page">
        <grid-view
            :main_route="'/admin/subsidization-organizations'"
            :id="{{$resource['id']}}"
            :locations_list="{{json_encode($locationsList)}}"
        ></grid-view>
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/subsidization_organizations.js')}}"></script>
@stop
