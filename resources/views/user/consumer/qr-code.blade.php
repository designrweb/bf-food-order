@extends('layouts.admin')

@section('content')
    <div id="qr-code-page">
        <qr-code-page
                :main_route="'/user/consumers'"
                title="@lang('Consumers')"
        ></qr-code-page>
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/user_consumers.js')}}"></script>
@stop
