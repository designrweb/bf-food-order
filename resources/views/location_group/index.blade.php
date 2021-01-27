@extends('layouts.admin')

@section('content')
    <div id="grid-index-page">
        <grid-index
            :main_route="'/admin/location-groups'"
            title="@lang('location-group.Location Groups')"
        ></grid-index>
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/location_group.js')}}"></script>
@stop
