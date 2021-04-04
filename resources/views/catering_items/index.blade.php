@extends('layouts.admin')

@section('content')
    <div id="grid-index-page">
        <grid-index
                :main_route="'/admin/catering-items'"
                title="@lang('catering-item.Catering Item')"
        ></grid-index>
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/catering_items.js')}}"></script>
@stop
