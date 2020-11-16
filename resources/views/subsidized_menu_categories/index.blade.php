@section('content')
    <div id="grid-index-page">
        <grid-index :main_route="'subsidized-menu-categories'"></grid-index>
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/subsidized_menu_categories.js')}}"></script>
@stop
