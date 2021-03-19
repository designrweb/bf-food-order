@extends('layouts.admin')

@section('content')
    <div id="meal-orders-page">
        <meal-orders
                :main_route="'/user/payments/meal-orders'"
                v-bind:user_consumer_exists="{{ $userConsumerExists ? 'true' : 'false' }}"
                title="@lang('payment.Meal Orders')"
        ></meal-orders>
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/user_payments.js')}}"></script>
@stop
