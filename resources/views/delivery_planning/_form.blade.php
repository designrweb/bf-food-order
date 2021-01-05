@extends('layouts.admin')

@section('content')
    <div id="grid-form-page">
        @if(!empty($resource))
            <grid-form :main_route="'/admin/delivery-planning'" :id="{{$resource['id']}}"></grid-form>
        @else
            <grid-form :main_route="'/admin/delivery-planning'"></grid-form>
        @endif
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/delivery_planning.js')}}"></script>
@stop

