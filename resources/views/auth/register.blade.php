@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('gender') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Gender</label>

                            <div class="col-md-6">
                                <select name="gender" id="gender" class="form-control" required>
                                    <option value=""> --Choose gender -- </option>
                                    <option value="M" {{ old('gender') == 'M' ? 'selected' : '' }}>Male</option>
                                    <option value="F" {{ old('gender') == 'F' ? 'selected' : '' }}>Female</option>
                                </select>

                                @if ($errors->has('gender'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('gender') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- <div class="row">
        <div class="col-md-8 col-md-offset-2">
        <div class="ui attached message">
            <div class="header">
                Welcome to Yaanzoni Point of Sale system.
            </div>
            <p>Fill out the form below to sign-up for a new account</p>
        </div>

        <form class="ui form attached fluid segment" method="POST" action="{{ route('register') }}">

        {{ csrf_field() }}
                <!-- <div class="two fields">
                    <div class="field {{ $errors->has('first_name') ? 'error' : '' }}">
                        <label>First Name</label>
                        <input placeholder="First Name" id="first_name" name="first_name" type="text" value="{{ old('first_name') }}">
                        @if ($errors->has('first_name'))
                            <div class="ui pointing red basic label">
                                {{ $errors->first('first_name') }}
                            </div>
                        @endif
                    </div>

                    <div class="field {{ $errors->has('last_name') ? 'error' : '' }}">
                        <label>Last Name</label>
                        <input placeholder="Last Name" id="last_name" name="last_name" type="text" value="{{ old('last_name') }}">
                        @if ($errors->has('last_name'))
                            <div class="ui pointing red basic label">
                            {{ $errors->first('last_name') }}
                            </div>
                        @endif
                    </div>
                </div> -->
                <!-- <div class="ui grid inline fields">
                    <div class="three wide column ">
                        <label>Name</label>
                    </div>
                    <div class="seven wide column field {{ $errors->has('name') ? 'error' : '' }}">
                    <div class="ui left icon corner labeled input">
                        <input placeholder="Name" type="text" id="name" name="name" value="{{ old('name') }}">
                        <i class="user icon"></i>
                        <div class="ui corner label">
                            <i class="asterisk icon"></i>
                        </div>
                    </div>

                    </div>

                    @if ($errors->has('name'))
                        <div class="ui left pointing red label">
                            {{ $errors->first('name') }}
                        </div>
                    @endif

                </div>

                <div class="ui grid inline fields">
                    <div class="three wide column">
                        <label>Gender</label>
                    </div>
                    <div class="seven wide column field {{ $errors->has('gender') ? 'error' : '' }}">
                        <select name="gender" id="gender" class="dropdown">
                            <option value=""> --Choose gender -- </option>
                            <option value="M" {{ old('gender') == 'M' ? 'selected' : '' }}>Male</option>
                            <option value="F" {{ old('gender') == 'F' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>

                    @if ($errors->has('gender'))
                        <div class="ui left pointing red label">
                            {{ $errors->first('gender') }}
                        </div>
                    @endif
                </div>

                <div class="ui grid inline fields">
                    <div class="three wide column">
                        <label>Email</label>
                    </div>
                    <div class="seven wide column field {{ $errors->has('email') ? 'error' : '' }}">
                        <div class="ui left icon corner labeled input">
                            <input placeholder="Email address" type="email" id="email" name="email" value="{{ old('email') }}">
                            <i class="mail icon"></i>
                            <div class="ui corner label">
                                <i class="asterisk icon"></i>
                            </div>
                        </div>

                    </div>
                    @if ($errors->has('email'))
                        <div class="ui left pointing red label">
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                </div>

                <div class="ui grid inline fields">
                    <div class="three wide column">
                        <label>Password</label>
                    </div>
                    <div class="seven wide column field {{ $errors->has('email') ? 'error' : '' }}">
                        <div class="ui left icon labeled input">
                            <input type="password" id="password" name="password">
                            <i class="key icon"></i>
                            <div class="ui corner label">
                                <i class="asterisk icon"></i>
                            </div>
                        </div>

                    </div>
                    @if ($errors->has('password'))
                        <div class="ui left pointing red label">
                            {{ $errors->first('password') }}
                        </div>
                    @endif
                </div>

                <div class="ui grid inline fields">
                    <div class="three wide column">
                        <label>Confirm Password</label>
                    </div>
                    <div class="seven wide column field">
                        <div class="ui left icon labeled input">
                            <input type="password" name="password_confirmation">
                            <i class="key icon"></i>
                            <div class="ui corner label">
                                <i class="asterisk icon"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="ui grid inline fields">
                    <div class="three wide column"></div>

                    <div class="seven wide column field {{ $errors->has('terms') ? 'error' : '' }}">
                        <div class="ui checkbox">
                        <input type="checkbox" id="terms" name="terms">
                        <label for="terms">I agree to the terms and conditions</label>
                        </div>
                    </div>
                </div>

                <div class="ui grid inline fields">
                    <div class="three wide column"></div>

                    <div class="seven wide column field">
                        <button type="submit" class="ui blue submit button">
                            Register
                        </button>
                    </div>
                </div>
            </form>
            <div class="ui bottom attached warning message">
            <i class="icon help"></i>
            Already signed up? <a href="{{ route('login') }}">Login here</a> instead.
            </div>
        </div>
    </div> -->
</div>
@endsection

@section('scripts')
<script>
    // $('select.dropdown').dropdown();
</script>
@stop
