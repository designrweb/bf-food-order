<?php
/**
 * @var array $resource
 */
?>
@section('content')
    <div id="grid-form-page">
        @if(!empty($resource))
            <grid-form :main_route="'consumers'" :id="{{$resource['id']}}"></grid-form>
        @else
            <grid-form :main_route="'consumers'"></grid-form>
        @endif
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/consumers.js')}}"></script>
@stop

