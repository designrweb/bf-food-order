<?php
/**
 * @var array $resource
 */
?>

@extends('layouts.admin')

@section('content')
    <div id="grid-form-page">
        @if(!empty($resource))
            <grid-form :main_route="'companies'" :id="{{$resource['id']}}"></grid-form>
        @else
            <grid-form :main_route="'companies'"></grid-form>
        @endif
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/companies.js')}}"></script>
@stop

