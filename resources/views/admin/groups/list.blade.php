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
                        <div class="col-sm-6"><i class="fas fa-boxes"></i> {{ __('Groups') }}</div>
                        <div class="col-sm-6">
                            <a href="{{ route('groups.create') }}" class="btn btn-primary btn-sm float-right" role="button"><i class="fas fa-plus"></i> {{ __('Add New') }}</a>
                        </div>
                    </div>
                </div>

                @if(count($groups))
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">{{ __('#') }}</th>
                                <th scope="col">{{ __('Name') }}</th>
                                <th scope="col">{{ __('Created/Updated By') }}</th>
                                @if(in_array(Auth::user()->id_profile, [1,2]))
                                    <th scope="col">{{ __('Actions') }}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($groups as $key => $group)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $group->name }}</td>
                                    <td>{{ $group->user->name }}</td>
                                    @if(in_array(Auth::user()->id_profile, [1,2]))
                                        <td>
                                            <a href="{{ route('groups.edit', array(base64_encode($group->id))) }}" id="btn-edit" class="btn btn-primary btn-sm btn-edit">
                                                <i class="fas fa-edit"></i> {{ __('Edit') }}
                                            </a>
                                            <a href="{{ route('groups.remove', array(base64_encode($group->id))) }}" id="btn-remove" class="btn btn-danger btn-sm btn-danger" onclick="return confirm('{{ __('Do you really want to remove this group?') }}');">
                                                <i class="fas fa-trash-alt"></i> {{ __('Remove') }}       
                                            </a>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        {{ $groups->links() }}
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
