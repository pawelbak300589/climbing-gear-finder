@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        {{ __('Permission') }}: {{ $permission->name }}
                        <a href="{{ route('admin.permissions.index') }}" class="text-danger float-right">Go back</a>
                    </div>

                    <div class="card-body">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
