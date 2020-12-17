<?php
/**
 * @var array $resource
 */
?>
@extends('layouts.admin')

@section('content')
    <div id="grid-form-page">
        @if(!empty($resource))
            <grid-form :main_route="'/admin/locations'" :id="{{$resource['id']}}" :companies_list="{{json_encode($resource['companiesList'])}}"></grid-form>
        @else
            <grid-form :main_route="'/admin/locations'" :companies_list="{{json_encode($companiesList)}}"></grid-form>
        @endif
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/locations.js')}}"></script>
@stop

