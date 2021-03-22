@extends('layouts.admin')

@section('content')
    <div id="index-form-page">
        <grid-index
                :main_route="'/user/order'"
                v-bind:user_consumer_exists="{{ $userConsumerExists ? 'true' : 'false' }}"
                title="@lang('order.Orders')"
        ></grid-index>
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/user_food_order.js')}}"></script>
@stop
