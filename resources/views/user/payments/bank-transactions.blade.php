@extends('layouts.admin')

@section('content')
    <div id="grid-index-page">
        <grid-index
                :main_route="'/user/payments/bank-transactions'"
                v-bind:user_consumer_exists="{{ $userConsumerExists ? 'true' : 'false' }}"
                title="@lang('payment.Bank Transactions')"
        ></grid-index>
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/user_payments.js')}}"></script>
@stop
