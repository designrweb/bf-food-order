<?php
/**
 * @var array $resource
 */
?>
@extends('layouts.admin')

@section('content')
    <div id="grid-form-page">
        @if(!empty($resource))
            <grid-form
                :main_route="'/user/payments'"
                :id="{{$resource['id']}}"
                :consumers_list="{{json_encode($resource['consumersList'])}}"
                title="{{ __('payment.Update Payment', ['name' => $resource['name']]) }}"
            ></grid-form>
        @else
            <grid-form
                :main_route="'/user/payments'"
                :consumers_list="{{json_encode($consumersList)}}"
                title="@lang('payment.Add Payment')"
            ></grid-form>
        @endif
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/user_payments.js')}}"></script>
@stop

