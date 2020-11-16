@extends('layouts.admin')

@section('content')
    <div id="grid-index-page">
        <grid-index :main_route="'consumer-subsidizations'"></grid-index>
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/consumer_subsidizations.js')}}"></script>
@stop
