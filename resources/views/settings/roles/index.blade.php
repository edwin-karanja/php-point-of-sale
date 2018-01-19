@extends('settings._layout')

@section('page-title')
    Settings/Roles
@endsection

@section('settings-content')
    <div class="panel panel-default">
        <div class="panel-heading clearfix">
            <a href="{{ route('settings.roles.create') }}" class="btn btn-primary">New Role</a>
        </div>
        <div class="panel-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>##</th>
                        <th>Name</th>
                        <th>Users count</th>
                        <th>Permissions</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $key => $role)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td><a href="#">{{ $role->name }}</a></td>
                            <td>{{ $role->users->count() }} {{ str_plural('user', $role->users->count())}}</td>
                            <td><a href="{{ route('settings.roles.assign', $role)}}">{{ $role->permissions->count() }} {{ str_plural('permissions', $role->permissions->count()) }}</a></td>
                            <td>
                                <a href="{{ route('settings.roles.edit', $role) }}">
                                    <i class="fa fa-pencil-square-o"></i>
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection