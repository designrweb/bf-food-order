@extends('layouts.admin')

@section('content')
    <div id="grid-combined-form-page">
        <grid-combined-form
            :main_route="'/admin/settings'"
            title="@lang('setting.Settings')"
        ></grid-combined-form>
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/settings.js')}}"></script>
@stop
