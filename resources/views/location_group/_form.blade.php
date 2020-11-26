<?php
/**
 * @var array $resource
 */
?>
@extends('layouts.admin')

@section('content')
    <div id="grid-form-page">
        @if(!empty($resource))
            <grid-form :main_route="'location-groups'" :id="{{$resource['id']}}" :locations_list="{{json_encode($resource['locationsList'])}}"></grid-form>
        @else
            <grid-form :main_route="'location-groups'" :locations_list="{{json_encode($locationsList)}}"></grid-form>
        @endif
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/location_group.js')}}"></script>
@stop

