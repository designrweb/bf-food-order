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
                title="{{ __('subsidization.Update Subsidization Organization', ['name' => $resource['name']]) }}"
            ></grid-form>
        @else
            <grid-form
                :main_route="'/admin/subsidization-organizations'"
                title="@lang('subsidization.Create Subsidization Organization')"
            ></grid-form>
        @endif
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/subsidization_organizations.js')}}"></script>
@stop

