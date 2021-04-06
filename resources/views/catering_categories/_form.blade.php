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
                    :main_route="'/admin/catering-categories'"
                    :id="{{$resource['id']}}"
                    :locations_list="{{json_encode($resource['locationsList'])}}"
                    title="{{ __('catering-category.Update Catering Category', ['name' =>
                    $resource['name']]) }}"
            ></grid-form>
        @else
            <grid-form
                    :main_route="'/admin/catering-categories'"
                    :locations_list="{{json_encode($locationsList)}}"
                    title="@lang('catering-category.Create Catering Category')"
            ></grid-form>
        @endif
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/catering_categories.js')}}"></script>
@stop

