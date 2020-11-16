@extends('layouts.admin')

@section('content')
    <div id="grid-index-page">
        <grid-index :main_route="'consumer-qr-codes'"></grid-index>
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/consumer_qr_codes.js')}}"></script>
@stop
