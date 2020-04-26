@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12 mb-4">
                <a href="{{ route('admin.permissions.create') }}" class="btn btn-success float-right ml-2">Create New
                    Permission</a>
            </div>
            <div class="col-md-12">
                <table class="table table-hover">
                    <tr>
                        <th>Name</th>
                        <th>Number of Roles</th>
                        <th>Created</th>
                        <th>Last Update</th>
                        <th></th>
                    <tr>
                    @foreach($permissions as $permission)
                        <tr>
                            <td>{{ $permission->name }}</td>
                            <td>
                                <span class="badge badge-primary"
                                      data-toggle="tooltip" data-html="true"
                                      title="{{ $roles[$permission->id] }}">
                                    {{ $permission->roles->count() }}
                                </span>
                            </td>
                            <td>{{ $permission->created_at }}</td>
                            <td>{{ $permission->updated_at }}</td>
                            <td>
                                {{-- TODO: do some popup for accepting delete of user etc. --}}
                                <form method="POST" action="/admin/permissions/{{ $permission->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm float-right ml-2">
                                        Remove
                                    </button>
                                </form>
                                <a href="/admin/permissions/{{ $permission->id }}/edit"
                                   class="btn btn-primary btn-sm float-right ml-2">
                                    Edit
                                </a>
                                <a href="/admin/permissions/{{ $permission->id }}"
                                   class="btn btn-light btn-sm float-right ml-2">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    <script type="application/javascript">
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@endsection
