@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    <div class="card mt-4">
                        <div class="card-header">{{ __('Consumer') }}</div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">First Name</th>
                                    <th scope="col">Last Name</th>
                                    <th scope="col">Location</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach(auth()->user()->consumers as $consumer)
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>{{$consumer->firstname}}</td>
                                        <td>{{$consumer->firstname}}</td>
                                        <td>{{$consumer->locationGroup->name}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="card-header">{{ __('Create Consumer') }}</div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="firstname" class="cols-sm-2 control-label">{{ __('First Name') }}</label>

                                <div class="cols-sm-10">
                                    <input id="firstname" type="text" class="form-control @error('firstname') is-invalid @enderror" name="consumer[firstname]" value="{{ old('consumer[firstname]') }}" autocomplete="off" autofocus>

                                    @error('firstname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="lastname" class="cols-sm-2 control-label">{{ __('Last Name') }}</label>

                                <div class="cols-sm-10">
                                    <input id="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror" name="consumer[lastname]" value="{{ old('consumer[lastname]') }}" autocomplete="off" autofocus>

                                    @error('lastname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="location_group_id" class="cols-sm-2 control-label">{{ __('Location') }}</label>
                                    <select class="form-control" id="location_group_id" name="consumer[location_group_id]">
                                        @foreach($locationGroupList as $group)
                                            <option value="{{$group['id']}}">{{ $group['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="location_id" class="cols-sm-2 control-label">{{ __('Location Group') }}</label>
                                    <select class="form-control" id="location_id" name="consumer[location_id]">
                                        @foreach($locationList as $location)
                                            <option value="{{ $location['id'] }}">{{ $location['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="location_group_id" class="cols-sm-2 control-label">{{ __('Location') }}</label>
                                    <select class="form-control" id="location_group_id" name="consumer[location_group_id]">
                                        @foreach($locationGroupList as $group)
                                            <option value="{{$group['id']}}">{{ $group['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>


                            </div>
                        </div>
                        <div class="form-group row mb-0 mt-2">
                            <div class="col-md-12 offset-md-12">
                                <button type="submit" class="btn btn-primary btn-block">
                                    {{ __('Save') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection