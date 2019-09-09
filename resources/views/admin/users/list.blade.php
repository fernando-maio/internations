@extends('layouts.template')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @if(session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            @if(count($errors) > 0)
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        {{ $error }}<br />
                    @endforeach
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-6"><i class="fas fa-users"></i> {{ __('Users') }}</div>
                        <div class="col-sm-6">
                            @if(in_array(Auth::user()->id_profile, [1,2]))
                                <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm float-right" role="button"><i class="fas fa-plus"></i> {{ __('Add New') }}</a>
                            @endif
                        </div>
                    </div>
                </div>

                @if(count($users))
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">{{ __('Name') }}</th>
                                <th scope="col">{{ __('E-mail') }}</th>
                                <th scope="col">{{ __('Profile') }}</th>
                                <th scope="col">{{ __('Status') }}</th>
                                <th scope="col">{{ __('Admin Access') }}</th>
                                @if(in_array(Auth::user()->id_profile, [1,2]))
                                    <th scope="col">{{ __('Actions') }}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->profile->name }}</td>
                                    <td>
                                        @if($user->active)
                                            <span class="text-success">{{ __('Active') }}</span>
                                        @else
                                            <span class="text-danger">{{ __('Inactive') }}</span>
                                        @endif
                                    </td>
                                    @if(Auth::user()->id_profile == 1 || (Auth::user()->id_profile == 2 && $user->id_profile == 3))
                                        <td>
                                            @if($user->blocked)
                                                <span class="text-danger">{{ __('Blocked') }}</span>
                                            @else
                                                <span class="text-success">{{ __('Unblocked') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('users.edit', array(base64_encode($user->id))) }}" id="btn-edit" class="btn btn-primary btn-sm btn-edit">
                                                <i class="fas fa-edit"></i> {{ __('Edit') }}
                                            </a>
                                            <a href="{{ route('users.remove', array(base64_encode($user->id))) }}" id="btn-remove" class="btn btn-danger btn-sm btn-danger" onclick="return confirm('{{ __('Do you really want to remove this user?') }}');">
                                                <i class="fas fa-trash-alt"></i> {{ __('Remove') }}       
                                            </a>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        {{ $users->links() }}
                    </div>
                @else
                    <div class="p-4">
                        {{ __('Any register was found') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
