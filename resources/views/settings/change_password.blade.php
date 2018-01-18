@extends('settings._layout')

@section('page-title')
    Settings/Change password
@endsection

@section('settings-content')
<form class="form-horizontal" method="POST" action="{{ route('settings.change_password.store') }}">
    {{ csrf_field() }}

    <div class="form-group{{ $errors->has('old_password') ? ' has-error' : '' }}">
        <label for="name" class="col-md-3 control-label">Old Password</label>

        <div class="col-md-6">
            <input id="name" type="password" class="form-control" name="old_password" value="{{ old('old_password') }}" autofocus>

            @if ($errors->has('old_password'))
                <span class="help-block">
                    <strong>{{ $errors->first('old_password') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
        <label for="password" class="col-md-3 control-label">Password</label>

        <div class="col-md-6">
            <input id="password" type="password" class="form-control" name="password" >

            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <label for="password-confirm" class="col-md-3 control-label">Confirm Password</label>

        <div class="col-md-6">
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" >
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-6 col-md-offset-3">
            <button type="submit" class="btn btn-primary">
                Change Password
            </button>
        </div>
    </div>
</form>
@endsection