@extends('layouts.admin')

@section('content')
    <div id="grid-index-page">
        <grid-index
            :main_route="'/admin/administrators'"
            title="@lang('user.Administrators')"
        ></grid-index>
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/administrators.js')}}"></script>
@stop
