@extends('layouts.admin')

@section('content')
    <div id="grid-form-page">
        @isset($resource)
            <grid-form
                    :location_list="{{ json_encode($locationList) }}"
                    :main_route="'/user/consumers'"
                    :id="{{ $resource['id'] }}">
            </grid-form>
        @else
            <grid-form
                    :location_list="{{ json_encode($locationList) }}"
                    :main_route="'/user/consumers'">
            </grid-form>
        @endif
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/user_consumers.js')}}"></script>
@stop

