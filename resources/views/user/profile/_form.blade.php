@extends('layouts.admin')

@section('content')

    <div id="grid-form-page">
        <grid-form
                :main_route="'/user/profile'"
                :user="{{ json_encode($userInfo) }}"
                title="@lang('user.Profile')"
                :salutations_list="{{ json_encode($salutationsList) }}"
        ></grid-form>
    </div>

@endsection

@section('js')
    <script src="{{('/js/crud/profile.js')}}"></script>
@stop
