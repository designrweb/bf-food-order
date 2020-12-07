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
                    :main_route="'/admin/menu-items'"
                    :id="{{$resource['id']}}"
                    :locations_list="{{json_encode($resource['locationsList'])}}"
                    :menu_categories_list="{{json_encode($resource['menuCategoriesList'])}}"
            ></grid-form>
        @else
            <grid-form
                    :main_route="'/admin/menu-items'"
                    :locations_list="{{json_encode($locationsList)}}"
                    :menu_categories_list="{{json_encode($menuCategoriesList)}}"
            ></grid-form>
        @endif
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/menu_items.js')}}"></script>
@stop

