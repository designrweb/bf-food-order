@extends('layouts.frontend')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    <div class="card mt-4">
                        <div class="card-header">{{ __('Profile') }}</div>

                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <div class="form-group">
                                <label for="first_name" class="cols-sm-2 control-label">{{ __('First Name') }}</label>

                                <div class="cols-sm-10">
                                    <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="user_info[first_name]" value="{{ auth()->user()->userInfo->first_name ?? old('first_name') }}" required autocomplete="off" autofocus>

                                    @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="last_name" class="cols-sm-2 control-label">{{ __('Last Name') }}</label>

                                <div class="cols-sm-10">
                                    <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="user_info[last_name]" value="{{ auth()->user()->userInfo->last_name ?? old('last_name') }}" required autocomplete="off" autofocus>

                                    @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="salutation" class="cols-sm-2 control-label">{{ __('Salutation') }}</label>

                                <div class="cols-sm-10">
                                    <select class="form-control" id="salutation" name="user_info[salutation]">
                                        <option value="Herr">Herr</option>
                                        <option value="Frau">Frau</option>
                                    </select>
                                    @error('salutation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="zip" class="cols-sm-2 control-label">{{ __('Zip') }}</label>

                                <div class="cols-sm-10">
                                    <input id="zip" type="text" class="form-control @error('zip') is-invalid @enderror" name="user_info[zip]" value="{{ auth()->user()->userInfo->zip ?? old('zip') }}" required autocomplete="off" autofocus>

                                    @error('zip')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="city" class="cols-sm-2 control-label">{{ __('City') }}</label>

                                <div class="cols-sm-10">
                                    <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="user_info[city]" value="{{ auth()->user()->userInfo->city ?? old('city') }}" required autocomplete="off" autofocus>

                                    @error('city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="street" class="cols-sm-2 control-label">{{ __('Street') }}</label>

                                <div class="cols-sm-10">
                                    <input id="street" type="text" class="form-control @error('street') is-invalid @enderror" name="user_info[street]" value="{{ auth()->user()->userInfo->street ?? old('street') }}" required autocomplete="off" autofocus>

                                    @error('street')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    </div>
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
                            </div>

                            <div class="form-group">
                                <label for="location_group_id" class="cols-sm-2 control-label">{{ __('Location Group') }}</label>
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
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{('/js/crud/consumers.js')}}"></script>
@stop
