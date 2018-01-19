@extends('settings._layout')

@section('page-title')
    Settings/Roles/Create
@endsection

@section('settings-content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h1>Create new Role</h1>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" method="POST" action="{{ route('settings.roles.store') }}">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="name" class="col-md-3 control-label">Name</label>

                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" autofocus>

                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-3">
                        <button type="submit" class="btn btn-primary">
                            Create Role
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection