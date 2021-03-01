@extends('layouts.admin')

@section('content')
    <div id="grid-view-page">
        <grid-view
                subsidization_support_email="{{ $subsidizationSupportEmail }}"
                :main_route="'/user/consumers'"
                :id="{{ $resource['id'] }}"></grid-view>
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/user_consumers.js')}}"></script>
@stop
