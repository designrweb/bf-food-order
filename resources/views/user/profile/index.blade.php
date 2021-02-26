@extends('layouts.admin')

@section('content')
    <div id="grid-index-page">
        <grid-index
                :user="{{ json_encode($userInfo) }}"
                :main_route="'/user/profile'"
                title="@lang('user.Profile')"
        ></grid-index>
    </div>

    {{--Cumsumer table--}}
    @include('user.consumer.index')
@endsection

@section('js')
    <script src="{{('/js/crud/user.js')}}"></script>
@stop
