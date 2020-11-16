@extends('layouts.admin')

@section('content')
    <div id="grid-index-page">
        <grid-index :main_route="'menu-categories'"></grid-index>
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/menu_categories.js')}}"></script>
@stop
