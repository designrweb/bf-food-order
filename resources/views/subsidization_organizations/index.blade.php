@extends('layouts.admin')

@section('content')
    <div id="grid-index-page">
        <grid-index :main_route="'subsidization-organizations'"></grid-index>
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/subsidization_organizations.js')}}"></script>
@stop
