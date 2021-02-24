@extends('layouts.admin')

@section('content')

    <div id="grid-form-page">
        <grid-form
                :main_route="'/user/profile'"
                :user="{{ json_encode($userInfo) }}"
                :location_group_list="{{ json_encode($locationGroupList) }}"
                :location_list="{{ json_encode($locationList) }}"
                title="@lang('vacation.Create Vacation')"
        ></grid-form>
    </div>

@endsection

@section('js')
    <script src="{{('/js/crud/user.js')}}"></script>
@stop
