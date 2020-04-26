@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        {{ __('Create New Permission') }}
                        <a href="{{ route('admin.permissions.index') }}" class="text-danger float-right">Cancel</a>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.permissions.store') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                           class="form-control @error('name') is-invalid @enderror" name="name"
                                           value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                {{-- TODO: add javascript to 'select/unselect all' checkbox --}}
                                <div class="col-md-4">
                                    <input class="form-check-input position-static float-right" type="checkbox"
                                           value="" id="selectAllRoles">
                                </div>

                                <label class="form-check-label text-danger col-md-8" for="selectAllRoles">
                                    Select all roles
                                </label>
                                @foreach($roles as $role)
                                    @if (!in_array($role->name, ['SuperAdmin', 'Guest']))
                                        <div class="col-md-4">
                                            <input class="form-check-input position-static float-right" name="roles[]"
                                                   type="checkbox"
                                                   value="{{ $role->id }}" id="role{{ $role->id }}">
                                        </div>

                                        <label class="form-check-label col-md-6" for="role{{ $role->id }}">
                                            {{ $role->name }}
                                        </label>
                                    @endif
                                @endforeach
                                <div class="col-md-8 offset-md-4">
                                    <small id="permissionsHelpBlock" class="form-text text-muted">
                                        If you want a new role you will need to add it first
                                        <a href="{{ route('admin.roles.create') }}">here</a>
                                    </small>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-success">
                                        {{ __('Create Permission') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
