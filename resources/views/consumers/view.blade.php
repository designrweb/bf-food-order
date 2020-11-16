<?php
/**
 * @var array $resource
 */
?>
@section('content')
    <div id="grid-view-page">
        <grid-view :main_route="'consumers'" :id="{{$resource['id']}}"></grid-view>
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/consumers.js')}}"></script>
@stop
