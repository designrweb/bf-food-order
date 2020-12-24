<?php
/**
 * @var array $resource
 */
?>
@extends('layouts.admin')

@section('content')
    <div id="grid-form-page">
        @if(!empty($resource))
            <grid-form :main_route="'/admin/settings'" :id="{{$resource['id']}}"></grid-form>
        @else
            <grid-form :main_route="'/admin/settings'"></grid-form>
        @endif
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/settings.js')}}"></script>
@stop

