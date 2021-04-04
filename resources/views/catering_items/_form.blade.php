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
                    :main_route="'/admin/catering-items'"
                    :id="{{$resource['id']}}"
                    :catering_categories_list="{{json_encode
                    ($resource['cateringCategoriesList'])}}"
                    :statuses_list="{{json_encode
                    ($resource['statusesList'])}}"
                    title="{{ __('catering-item.Update Catering Item', ['name' =>
                    $resource['name']]) }}"
            ></grid-form>
        @else
            <grid-form
                    :main_route="'/admin/catering-items'"
                    :catering_categories_list="{{json_encode($cateringCategoriesList)}}"
                    :statuses_list="{{json_encode($statusesList)}}"
                    title="@lang('catering-item.Create Catering Item')"
            ></grid-form>
        @endif
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/catering_items.js')}}"></script>
@stop

