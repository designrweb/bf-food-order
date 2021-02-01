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
                    :main_route="'/admin/locations'"
                    :id="{{$resource['id']}}"
                    title="{{ __('location.Update Location', ['name' => $resource['name']]) }}"
            ></grid-form>
        @else
            <grid-form
                    :main_route="'/admin/locations'"
                    title="@lang('location.Create Location')"
            ></grid-form>
        @endif
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/locations.js')}}"></script>
@stop

