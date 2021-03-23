@extends('layouts.admin')

@section('content')
    <div id="qr-code-page">
        <qr-code-page
                :resource="{{ json_encode($qrCodeResource) }}"
                :main_route="'/user/consumers'"
                v-bind:is_consumers_exits="{{ $isConsumersExists ? 'true' : 'false' }}"
                title="@lang('consumer.QR Code'): {{ $qrCodeResource ? $qrCodeResource['consumer']['full_name'] : '' }}"
        ></qr-code-page>
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/user_consumers.js')}}"></script>
@stop
