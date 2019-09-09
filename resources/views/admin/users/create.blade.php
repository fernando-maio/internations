@extends('layouts.template')

@section('content')
    <div class="container">
        <div class="row justify-content-center">        
            <div class="col-md-10">
                <div class="messages">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                {{ $error }}<br />
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="card">
                    <form method="POST" action="{{ route('users.create') }}" class="text-center border border-light p-5">
                        @csrf
                        <p class="h4 mb-4">{{ __('New User') }}</p>

                        <input type="text" name="name" value="{{ old('name') }}" class="form-control mb-4" placeholder="{{ __('Full Name') }}" required>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control mb-4" placeholder="{{ __('E-mail') }}" required>
                        
                        <select name="id_profile" class="form-control mb-4" required>
                            <option value="" selected disabled>{{ __('Select Profile') }}</option>
                            @foreach($profiles as $profile)
                                <option value="{{ $profile->id }}">{{ $profile->name }}</option>
                            @endforeach
                        </select>
                        
                        <select name="active" class="form-control mb-4">
                            <option value="1" selected>{{ __('Active') }}</option>
                            <option value="0">{{ __('Inactive') }}</option>
                        </select>

                        <input type="password" name="password" class="form-control mb-4" placeholder="{{ __('Password') }}" required>
                        <input type="password" name="password_confirmation" class="form-control mb-4" placeholder="{{ __('Confirm Password') }}" required>

                        <div class="card mb-5">
                            <div class="card-header">
                                {{ __('Groups') }}
                            </div>
                            <div class="card-body">
                                @foreach($groups as $group)
                                    <div class="row col-sm-12">
                                        <div class="input-group-prepend col-sm-12 mb-1">
                                            <div class="input-group-text col-sm-12">
                                                <input type="checkbox" name="groups[]" value="{{ $group->id }}" class="mr-1">{{ $group->name }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <a class="col-sm-5 float-left" href="{{ route('users.list') }}" role="button">{{ __('Cancel') }}</a>
                        <button type="submit" class="btn btn-success col-sm-5 float-right">{{ __('Create') }}</button>
                    </form>                
                </div>
            </div>
        </div>
    </div>
@endsection