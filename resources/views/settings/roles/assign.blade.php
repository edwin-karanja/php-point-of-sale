@extends('settings._layout')

@section('page-title')
    Settings/Roles/Assign permissions
@endsection

@section('settings-content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h1>Assign: {{ ucwords($role->name) }} permissions</h1>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" method="POST" action="{{ route('settings.roles.assign.perms', $role) }}">
                {{ csrf_field() }}

                @foreach($permissions as $perm)
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="{{ $perm->name }}" {{ in_array($perm->name, $role_perms) ? 'checked' : ''}}> {{ $perm->name }}
                        </label>
                    </div>
                @endforeach

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-3">
                        <button type="submit" class="btn btn-primary">
                            Update permissions
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection