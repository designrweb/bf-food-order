@section('content')
    <div id="grid-index-page">
        <grid-index :main_route="'vacation-location-group'"></grid-index>
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/vacation_location_group.js')}}"></script>
@stop
