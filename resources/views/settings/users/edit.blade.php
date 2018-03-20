@extends('settings._layout')

@section('page-title')
    Settings\Users\Edit
@endsection

@section('settings-content')
    <form method="POST" action="{{ route('settings.users.update', $user) }}">
        {{ csrf_field() }}

        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label for="name" class="control-label">Name</label>
            <input id="name" type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}" required autofocus>

            @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif

        </div>

        <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
            <label for="name" class="control-label">Gender</label>

            <select name="gender" id="gender" class="form-control" required>
                <option value=""> --Choose gender -- </option>
                <option value="M" {{ old('gender', $user->gender) == 'M' ? 'selected' : '' }}>Male</option>
                <option value="F" {{ old('gender', $user->gender) == 'F' ? 'selected' : '' }}>Female</option>
            </select>

            @if ($errors->has('gender'))
                <span class="help-block">
                    <strong>{{ $errors->first('gender') }}</strong>
                </span>
            @endif

        </div>

        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <label for="email" class="control-label">E-Mail Address</label>

            <input id="email" type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" required>
            <small id="emailHelp" class="form-text text-muted">This is the email used to log in to the system.</small>

            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif

        </div>

        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <label for="email" class="control-label">Password</label>

            <input id="email" type="password" class="form-control" name="password" value="" required>

            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif

        </div>

        <div class="form-group">
            <label for="password-confirm" class="control-label">Confirm Password</label>
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-plus"></i>
                Update User
            </button>

            <a href="{{ route('settings.users.index') }}" class="btn btn-default pull-right">
                Cancel
            </a>
        </div>
    </form>
@endsection