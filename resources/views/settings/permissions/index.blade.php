@extends('settings._layout')

@section('page-title')
    Settings/Permissions
@endsection

@section('settings-content')
    <div class="panel panel-default">
        <div class="panel-heading clearfix">
            <a href="{{ route('settings.permissions.create') }}" class="btn btn-primary">New Permission</a>
        </div>
        <div class="panel-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>##</th>
                        <th>Name</th>
                        <th>Users count</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($permissions as $key => $perm)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ $perm->name }}</td>
                            <td>{{ $perm->users->count() }} {{ str_plural('user', $perm->users->count())}}</td>
                            <td>
                                <a href="{{ route('settings.permissions.edit', $perm) }}">
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