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
                    <form method="POST" action="{{ route('groups.edit', array(base64_encode($group->id))) }}" class="text-center border border-light p-5">
                        @csrf
                        <p class="h4 mb-4">{{ __('Edit Group') }}</p>

                        <input type="text" name="name" value="{{ $group->name }}" class="form-control mb-4" placeholder="{{ __('Name') }}" required>

                        <a class="col-sm-5 float-left" href="{{ route('groups.list') }}" role="button">{{ __('Cancel') }}</a>
                        <button type="submit" class="btn btn-success col-sm-5 float-right">{{ __('Edit') }}</button>
                    </form>                
                </div>
            </div>
        </div>
    </div>

@endsection