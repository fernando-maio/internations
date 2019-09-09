@extends('layouts.template')

@section('content')
<div class="container">
    <div class="row justify-content-center">        
        <div class="col-md-10">
            <div class="messages">
                @if(count($errors) > 0)
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            {{ $error }}<br />
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="card">
                <form method="POST" action="{{ route('users.edit', array(base64_encode($user->id))) }}" class="text-center border border-light p-5">
                    @csrf
                    <p class="h4 mb-4">{{ __('Edit User') }}</p>

                    <input type="text" name="name" value="{{ $user->name }}" class="form-control mb-4" placeholder="{{ __('Last Name') }}" required>
                    <input type="email" name="email" value="{{ $user->email }}" class="form-control mb-4" placeholder="{{ __('E-mail') }}" disabled>

                    <select name="active" class="form-control mb-4">
                        <option value="1">{{ __('Active') }}</option>
                        <option value="0" {!! !$user->active ? 'selected' : '' !!}>{{ __('Inactive') }}</option>
                    </select>
                    
                    @if((Auth::user()->id_profile == 1 && $user->id_profile != 1) || (Auth::user()->id_profile == 2 && $user->id_profile == 3))
                        <select name="id_profile" class="form-control mb-4" required>
                            @foreach($profiles as $profile)
                                <option value="{{ $profile->id }}" {!! $user->id_profile == $profile->id ? 'selected' : '' !!}>{{ $profile->name }}</option>
                            @endforeach
                        </select>
                        <select name="blocked" class="form-control mb-4">
                            <option value="0">{{ __('Unblocked') }}</option>
                            <option value="1" {!! $user->blocked ? 'selected' : '' !!}>{{ __('Blocked') }}</option>
                        </select>
                    @endif

                    @if(Auth::user()->id == $user->id)
                        <input type="password" name="password" class="form-control mb-4" placeholder="{{ __('Password') }}">
                        <input type="password" name="password_confirmation" class="form-control mb-4" placeholder="{{ __('Confirm Password') }}">
                    @endif

                    <div class="card mb-5">
                        <div class="card-header">
                            {{ __('Groups') }}
                        </div>
                        <div class="card-body">
                            @foreach($groups as $group)
                                <div class="row col-sm-12">
                                    <div class="input-group-prepend col-sm-12 mb-1">
                                        <div class="input-group-text col-sm-12">
                                            <input type="checkbox" name="groups[]" value="{{ $group->id }}" class="mr-1" {!! in_array($group->id, $user->groups) ? 'checked' : '' !!}>{{ $group->name }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <a class="col-sm-5 float-left" href="{{ route('users.list') }}" role="button">{{ __('Cancel') }}</a>
                    <button type="submit" class="btn btn-success col-sm-5 float-right">{{ __('Edit') }}</button>
                </form>                
            </div>
        </div>
    </div>
</div>
@endsection
