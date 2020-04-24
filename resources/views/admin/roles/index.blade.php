@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12 mb-4">
                <a href="{{ route('admin.roles.create') }}" class="btn btn-success float-right ml-2">Create New Role</a>
            </div>
            <div class="col-md-12">
                <table class="table table-hover">
                    <tr>
                        <th>Name</th>
                        <th>Number of Users</th>
                        <th>Created</th>
                        <th>Last Update</th>
                        <th></th>
                    <tr>
                    @foreach($roles as $role)
                        <tr>
                            <td>{{ $role->name }}</td>
                            <td><span class="badge badge-primary">{{ $role->users->count() }}</span></td>
                            <td>{{ $role->created_at }}</td>
                            <td>{{ $role->updated_at }}</td>
                            <td>
                                @if ($role->name !== 'SuperAdmin')
                                    <span class="btn btn-secondary btn-sm float-right ml-2 active"
                                          style="cursor: no-drop;">Remove</span>
                                    {{-- TODO: do some popup for accepting delete of user etc. --}}
                                    <form method="POST" action="admin/roles/{{ $role->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm float-right ml-2">Remove
                                        </button>
                                    </form>
                                    <a href="admin/roles/{{ $role->id }}/edit"
                                       class="btn btn-primary btn-sm float-right ml-2">Edit</a>
                                    <a href="admin/roles/{{ $role->id }}" class="btn btn-light btn-sm float-right ml-2">
                                        View Details
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
