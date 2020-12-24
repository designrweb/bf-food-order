@extends('layouts.admin')

@section('content')
  <div id="meal-orders-page">
    <meal-orders :main_route="'/admin/payments/meal-orders'"></meal-orders>
  </div>
@endsection

@section('js')
  <script src="{{('/js/crud/payments.js')}}"></script>
@stop
