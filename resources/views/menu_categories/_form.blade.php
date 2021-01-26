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
                    :existing_orders="{{json_encode($resource['existingOrders'])}}"
                    :id="{{$resource['id']}}"
                    title="{{ __('menu-category.Update Menu Category', ['name' => $resource['name']]) }}"
            ></grid-form>
        @else
            <grid-form
                    :main_route="'/admin/menu-categories'"
                    :locations_list="{{json_encode($locationsList)}}"
                    :existing_orders="{{json_encode($existingOrders)}}"
                    title="@lang('menu-category.Create Menu Category')"
            ></grid-form>
        @endif
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/menu_categories.js')}}"></script>
@stop

