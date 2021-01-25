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
                :main_route="'/admin/settings'"
                :id="{{$resource['id']}}"
                title="{{ __('setting.Update Setting', ['name' => $resource['visible_name']]) }}"
            ></grid-form>
        @else
            <grid-form
                :main_route="'/admin/settings'"
                title="@lang('setting.Create Setting')"
            ></grid-form>
        @endif
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/settings.js')}}"></script>
@stop

