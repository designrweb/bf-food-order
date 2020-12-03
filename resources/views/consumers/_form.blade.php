<?php
/**
 * @var array $resource
 */
?>
@extends('layouts.admin')

@section('content')
    <div id="grid-form-page">
        @if(!empty($resource))
            <grid-form :main_route="'/admin/consumers'" :id="{{$resource['id']}}" :location_group_list="{{json_encode($resource['locationGroupList'])}}"></grid-form>
        @else
            <grid-form :main_route="'/admin/consumers'" :location_group_list="{{json_encode($locationGroupList)}}"></grid-form>
        @endif
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/consumers.js')}}"></script>
@stop

