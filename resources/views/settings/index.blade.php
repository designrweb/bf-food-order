@extends('layouts.admin')

@section('content')
    <div id="grid-index-page">
        <grid-index
            :main_route="'/admin/settings'"
            title="@lang('setting.Settings')"
        ></grid-index>
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/settings.js')}}"></script>
@stop
