@extends('layouts.admin')

@section('content')
    <div id="grid-index-page">
        <grid-index
                :user="{{ json_encode($userInfo) }}"
                :main_route="'/user/profile'"
                :salutations_list="{{ json_encode($salutationsList) }}"
                title="@lang('user.Profile')"
        ></grid-index>
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/profile.js')}}"></script>
@stop
