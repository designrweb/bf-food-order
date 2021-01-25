@extends('layouts.admin')

@section('content')
    <div id="grid-index-page">
        <grid-index
            :main_route="'/admin/delivery-planning'"
            title="@lang('order.Delivery Planning')"
        ></grid-index>
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/delivery_planning.js')}}"></script>
@stop
