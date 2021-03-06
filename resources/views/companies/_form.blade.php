<?php
/**
 * @var array $resource
 */
?>

@extends('layouts.admin')

@section('content')
  <div id="grid-form-page">
    @if(!empty($resource))
      <grid-form
          :main_route="'/admin/companies'"
          :id="{{$resource['id']}}"
          title="@lang('company.Companies')"
      ></grid-form>
    @else
      <grid-form
          :main_route="'/admin/companies'"
          title="@lang('company.Companies')"
      ></grid-form>
    @endif
  </div>
@endsection

@section('js')
  <script src="{{('/js/crud/companies.js')}}"></script>
@stop

