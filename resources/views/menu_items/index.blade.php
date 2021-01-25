@extends('layouts.admin')

@section('content')
    <div id="grid-index-page">
        <grid-index
            :main_route="'/admin/menu-items'"
            title="@lang('menu-item.Menu Items')"
        ></grid-index>
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/menu_items.js')}}"></script>
@stop
