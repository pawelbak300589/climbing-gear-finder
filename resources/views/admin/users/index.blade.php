@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12 mb-4">
                <a href="{{ route('admin.users.create') }}" class="btn btn-success float-right ml-2">Create New User</a>
            </div>
            <div class="col-md-12">
                <table class="table table-hover">
                    <tr>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Email</th>
                        <th>Email Verified?</th>
                        <th>Created</th>
                        <th>Last Update</th>
                        <th></th>
                    <tr>
                    @foreach($users as $user)
                        <tr class="{{ $user->getTableClass() }}">
                            <td>{{ $user->name }}</td>
                            <td>
                                @foreach($user->getRoleNames() as $role)
                                    <span class="badge badge-primary">{{ $role }}</span>
                                @endforeach
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->email_verified_at }}</td>
                            <td>{{ $user->created_at }}</td>
                            <td>{{ $user->updated_at }}</td>
                            <td>
                                @if ($user->id === auth()->user()->id)
                                    <span class="btn btn-secondary float-right ml-2 active" style="cursor: no-drop;">Remove</span>
                                @else
                                    {{-- TODO: do some popup for accepting delete of user etc. --}}
                                    <a href="{{ $user->adminPath() . '/destroy' }}" class="btn btn-danger float-right ml-2">Remove</a>
                                @endif
                                <a href="{{ $user->adminPath() . '/edit' }}" class="btn btn-primary float-right ml-2">Edit</a>
                                <a href="{{ $user->adminPath() }}" class="btn btn-light float-right ml-2">View Details</a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
