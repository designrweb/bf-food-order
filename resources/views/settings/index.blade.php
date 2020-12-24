@extends('layouts.admin')

@section('content')
    <div id="grid-index-page">
        <grid-index :main_route="'/admin/settings'"></grid-index>
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/settings.js')}}"></script>
@stop
