<?php
/**
 * @var array $resource
 */
?>
@section('content')
    <div id="grid-view-page">
        <grid-view :main_route="'consumer-subsidizations'" :id="{{$resource['id']}}"></grid-view>
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/consumer_subsidizations.js')}}"></script>
@stop
