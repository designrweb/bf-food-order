@extends('layouts.admin')

@section('content')
  <div id="grid-index-page">
    <grid-index
        :main_route="'payment-dumps'"
        title="@lang('payment-dump.Payment Dumps')"
    ></grid-index>
  </div>
@endsection

@section('js')
  <script src="{{('/js/crud/payment-dumps.js')}}"></script>
@stop
