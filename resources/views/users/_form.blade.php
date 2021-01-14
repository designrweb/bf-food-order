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
                    :id="{{$resource['id']}}"
            ></grid-form>
        @else
            <grid-form
                    :main_route="'/admin/users'"
                    :salutations_list="{{json_encode($salutationsList)}}"
                    :roles_list="{{json_encode($rolesList)}}"
            ></grid-form>
        @endif
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/users.js')}}"></script>
@stop

