@extends('layouts.admin')

@section('content')
    <div id="grid-index-page">
        <grid-index :main_route="'/admin/companies'"></grid-index>
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/companies.js')}}"></script>
@stop
