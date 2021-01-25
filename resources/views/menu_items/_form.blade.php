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
                    :menu_categories_list="{{json_encode($resource['menuCategoriesList'])}}"
                    title="{{ __('menu-item.Update Menuitem', ['name' => $resource['name']]) }}"
            ></grid-form>
        @else
            <grid-form
                    :main_route="'/admin/menu-items'"
                    :menu_categories_list="{{json_encode($menuCategoriesList)}}"
                    title="@lang('menu-item.Create Menuitem')"
            ></grid-form>
        @endif
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/menu_items.js')}}"></script>
@stop

