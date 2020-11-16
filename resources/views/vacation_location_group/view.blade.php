<?php
/**
 * @var array $resource
 */
?>
@section('content')
    <div id="grid-view-page">
        <grid-view :main_route="'vacation-location-group'" :id="{{$resource['id']}}"></grid-view>
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/vacation_location_group.js')}}"></script>
@stop
