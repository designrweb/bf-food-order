<?php
/**
 * @var array $resource
 */
?>

@extends('layouts.admin')

@section('content')
    <div id="grid-form-page">
        @if(!empty($resource))
            <grid-form :main_route="'/admin/vacations'" :id="{{$resource['id']}}"></grid-form>
        @else
            <grid-form :main_route="'/admin/vacations'"></grid-form>
        @endif
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/vacation.js')}}"></script>
@stop

