@extends('settings._layout')

@section('page-title')
    Settings\Users
@endsection

@section('settings-content')
    <a href="{{ route('settings.users.create') }}" class="btn btn-success pull-right">
        <i class="fa fa-plus"></i>
        Add User
    </a>
    <br>
    <br>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>##</th>
                <th>Name</th>
                <th>Email</th>
                <th>Gender</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $index => $user)
                <tr>
                    <td>{{ ++$index }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->gender == 'M' ? 'Male' : 'Female' }}</td>
                    <td>{{ $user->isAdmin() ? 'Admin' : 'Standard' }}</td>
                    <td>
                        @if (auth()->user()->id !== $user->id)
                            <span><a href="{{ route('settings.users.edit', $user) }}">Edit</a></span>

                            <span class="pull-right">
                                <i class="fa fa-trash" style="color:#be3934"></i>
                                <a href="{{ route('settings.users.destroy', $user) }}" onclick="confirm('Are you sure you want to delete this user?')">Delete</a>
                            </span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection