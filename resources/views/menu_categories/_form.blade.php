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
                    :main_route="'/admin/menu-categories'"
                    :locations_list="{{json_encode($resource['locationsList'])}}"
                    :id="{{$resource['id']}}"
            ></grid-form>
        @else
            <grid-form
                    :main_route="'/admin/menu-categories'"
                    :locations_list="{{json_encode($locationsList)}}"
            ></grid-form>
        @endif
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/menu_categories.js')}}"></script>
@stop

