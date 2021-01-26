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
                    :main_route="'/admin/users'"
                    :salutations_list="{{json_encode($resource['salutationsList'])}}"
                    :roles_list="{{json_encode($resource['rolesList'])}}"
                    :locations_list="{{json_encode($resource['locationsList'])}}"
                    :id="{{$resource['id']}}"
                    title="{{ __('user.Update User', ['name' => $resource['user_info']['first_name'] . ' ' . $resource['user_info']['last_name']]) }}"
            ></grid-form>
        @else
            <grid-form
                    :main_route="'/admin/users'"
                    :salutations_list="{{json_encode($salutationsList)}}"
                    :roles_list="{{json_encode($rolesList)}}"
                    :locations_list="{{json_encode($locationsList)}}"
                    title="@lang('user.Create User')"
            ></grid-form>
        @endif
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/users.js')}}"></script>
@stop

