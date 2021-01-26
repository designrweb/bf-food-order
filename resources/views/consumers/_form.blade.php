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
                    :main_route="'/admin/consumers'"
                    :id="{{$resource['id']}}"
                    :location_group_list="{{json_encode($resource['locationGroupList'])}}"
                    :subsidization_organization_list="{{json_encode($resource['subsidizationOrganizationList'])}}"
                    title="@lang('consumer.Update Consumer: ')"
                    subsidizationTitle="@lang('subsidization.Subsidization information')"
            ></grid-form>
        @else
            <grid-form
                    :main_route="'/admin/consumers'"
                    :location_group_list="{{json_encode($locationGroupList)}}"
                    :subsidization_organization_list="{{json_encode($subsidizationOrganizationList)}}"
                    title="@lang('consumer.Create Consumer')"
                    subsidizationTitle="@lang('subsidization.Subsidization information')"
            ></grid-form>
        @endif
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/consumers.js')}}"></script>
@stop

