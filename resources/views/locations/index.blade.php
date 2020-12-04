@extends('layouts.admin')

@section('content')
    <div id="grid-index-page">
        <grid-index :main_route="'/admin/locations'"></grid-index>
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/locations.js')}}"></script>
@stop
