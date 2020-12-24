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
                    :main_route="'/admin/subsidization-rules'"
                    :id="{{$resource['id']}}"
                    :subsidization_organizations_list="{{json_encode($resource['subsidizationOrganizations'])}}"
                    :subsidization_menu_categories_list="{{json_encode($resource['subsidizationMenuCategories'])}}"
            ></grid-form>
        @else
            <grid-form
                    :main_route="'/admin/subsidization-rules'"
                    :subsidization_organizations_list="{{json_encode($subsidizationOrganizations)}}"
                    :subsidization_menu_categories_list="{{json_encode($subsidizationMenuCategories)}}"
            ></grid-form>
        @endif
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/subsidization_rules.js')}}"></script>
@stop

