<?php
/**
 * @var array $resource
 */
?>
@section('content')
    <div id="grid-form-page">
        @if(!empty($resource))
            <grid-form :main_route="'consumer-subsidizations'" :id="{{$resource['id']}}"></grid-form>
        @else
            <grid-form :main_route="'consumer-subsidizations'"></grid-form>
        @endif
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/consumer_subsidizations.js')}}"></script>
@stop

