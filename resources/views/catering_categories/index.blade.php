@extends('layouts.admin')

@section('content')
    <div id="grid-index-page">
        <grid-index
                :main_route="'/admin/catering-categories'"
                title="@lang('catering-category.Catering Categories')"
        ></grid-index>
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/catering_categories.js')}}"></script>
@stop
