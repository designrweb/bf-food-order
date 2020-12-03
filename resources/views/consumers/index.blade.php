@extends('layouts.admin')

@section('content')
    <div id="grid-index-page">
        <grid-index :main_route="'/admin/consumers'"></grid-index>
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/consumers.js')}}"></script>
@stop
