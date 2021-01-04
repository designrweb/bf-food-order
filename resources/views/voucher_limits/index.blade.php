@extends('layouts.admin')

@section('content')
    <div id="grid-index-page">
        <grid-index
                :main_route="'voucher-limits'"
                :menu_categories="{{json_encode($menuCategories)}}"
                :weeklylist="{{json_encode($voucherLimits)}}"
        ></grid-index>
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/voucher_limits.js')}}"></script>
@stop
