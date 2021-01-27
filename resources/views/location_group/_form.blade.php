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
                :main_route="'/admin/location-groups'"
                :id="{{$resource['id']}}"
                :locations_list="{{json_encode($resource['locationsList'])}}"
                title="{{__('location-group.Update Location Group', ['name' => $resource['name']])}}"
            ></grid-form>
        @else
            <grid-form
                :main_route="'/admin/location-groups'"
                :locations_list="{{json_encode($locationsList)}}"
                title="@lang('location-group.Create Location Group')"
            ></grid-form>
        @endif
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/location_group.js')}}"></script>
@stop

