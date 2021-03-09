@extends('layouts.admin')

@section('content')
    <div id="grid-form-page">
        <grid-form
                :main_route="'/user/consumers'"
                title="@lang('Consumers')"
        ></grid-form>
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/user_food_order.js')}}"></script>
@stop
