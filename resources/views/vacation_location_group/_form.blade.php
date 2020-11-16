<?php
/**
 * @var array $resource
 */
?>
@section('content')
    <div id="grid-form-page">
        @if(!empty($resource))
            <grid-form :main_route="'vacation-location-group'" :id="{{$resource['id']}}"></grid-form>
        @else
            <grid-form :main_route="'vacation-location-group'"></grid-form>
        @endif
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/vacation_location_group.js')}}"></script>
@stop

