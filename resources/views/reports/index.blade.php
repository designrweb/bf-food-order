@extends('layouts.admin')

@section('content')
    <div id="grid-index-page">
        <grid-index
            :main_route="'reports'"
            :locations_list="{{json_encode($locationsList)}}"
            title="@lang('report.Financial Export')"
        ></grid-index>
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/reports.js')}}"></script>
@stop
