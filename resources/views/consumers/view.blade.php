<?php
/**
 * @var array $resource
 */
?>
@extends('layouts.admin')

@section('content')
    <div id="grid-view-page">
        <grid-view
                :subsidization_organization_list="{{ json_encode($resource['subsidizationOrganizationList']) }}"
                :main_route="'/admin/consumers'"
                :id="{{ $resource['id'] }}"></grid-view>
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/consumers.js')}}"></script>
@stop
