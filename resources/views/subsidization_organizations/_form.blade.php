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
                :main_route="'/admin/subsidization-organizations'"
                :id="{{$resource['id']}}"
                :companies_list="{{json_encode($resource['companiesList'])}}"
                title="{{ __('subsidization.Update Subsidization Organization', ['name' => $resource['name']]) }}"
            ></grid-form>
        @else
            <grid-form
                :main_route="'/admin/subsidization-organizations'"
                :companies_list="{{json_encode($companiesList)}}"
                title="@lang('subsidization.Create Subsidization Organization')"
            ></grid-form>
        @endif
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/subsidization_organizations.js')}}"></script>
@stop

