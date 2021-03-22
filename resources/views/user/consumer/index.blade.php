@extends('layouts.admin')

@section('content')
    <div id="grid-index-page">
        <grid-index
            :main_route="'/user/consumers'"
            title="@lang('consumer.Consumers')"
        ></grid-index>
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/user_consumers.js')}}"></script>
@stop
