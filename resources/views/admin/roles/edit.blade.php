@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        {{ __('Edit Role') }}
                        <a href="{{ route('admin.roles.index') }}" class="text-danger float-right">Cancel</a>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="/admin/roles/{{ $role->id }}">
                            @csrf
                            @method('PATCH')

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">
                                    {{ __('Name') }}
                                </label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                           class="form-control @error('name') is-invalid @enderror" name="name"
                                           value="{{ old('name', $role->name) }}" required autocomplete="name"
                                           autofocus>

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
                                           value="" id="selectAllPermission">
                                </div>

                                <label class="form-check-label text-danger col-md-8" for="selectAllPermission">
                                    Select all permissions (equivalent of SuperAdmin)
                                </label>
                                @foreach($permissions as $permission)
                                    <div class="col-md-4">
                                        <input class="form-check-input position-static float-right"
                                               name="permissions[]"
                                               type="checkbox"
                                               value="{{ $permission->id }}" id="permission{{ $permission->id }}"
                                            {{ $role->hasPermissionTo($permission->id) ? ' checked' : '' }}>
                                    </div>

                                    <label class="form-check-label col-md-6" for="permission{{ $permission->id }}">
                                        {{ $permission->name }}
                                    </label>
                                @endforeach
                                <div class="col-md-8 offset-md-4">
                                    <small id="permissionsHelpBlock" class="form-text text-muted">
                                        If you want a new permission you will need to add it first
                                        <a href="{{ route('admin.permissions.create') }}">here</a>
                                    </small>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-success">
                                        {{ __('Update Role') }}
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
