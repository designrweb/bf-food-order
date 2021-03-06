@extends('layouts.admin')

@section('content')
    <div id="grid-index-page">
        <grid-index
                :main_route="'/admin/payments/bank-transactions'"
                :main_route_edit="'/admin/payments'"
                title="@lang('payment.Bank Transactions')"
        ></grid-index>
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/payments.js')}}"></script>
@stop
