<?php
/**
 * @var array $resource
 */
?>
@extends('layouts.admin')

@section('content')
    <div id="grid-form-page">
        @if(!empty($resource))
            <grid-form :main_route="'subsidized-menu-categories'" :id="{{$resource['id']}}"></grid-form>
        @else
            <grid-form :main_route="'subsidized-menu-categories'"></grid-form>
        @endif
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/subsidized_menu_categories.js')}}"></script>
@stop

