@extends('layouts.admin')

@section('content')
    <div id="grid-index-page">
        <grid-index :main_route="'orders'"></grid-index>
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/orders.js')}}"></script>
@stop
