@extends('layouts.admin')

@section('content')
    <div id="grid-index-page">
        <grid-index
            :main_route="'/admin/subsidization-rules'"
            title="@lang('subsidization.Subsidization Rules')"
        ></grid-index>
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/subsidization_rules.js')}}"></script>
@stop
