@extends('layouts.admin')

@section('content')
    <div id="grid-index-page">
        <grid-index
            :main_route="'/admin/vacations'"
            title="@lang('vacation.Vacations')"
        ></grid-index>
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/vacation.js')}}"></script>
@stop
