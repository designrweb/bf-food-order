@extends('layouts.admin')

@section('content')
    <div id="grid-index-page">
        <grid-index :main_route="'consumer-auto-orders'"></grid-index>
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/consumer_auto_orders.js')}}"></script>
@stop
