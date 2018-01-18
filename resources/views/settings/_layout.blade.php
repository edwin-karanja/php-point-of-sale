@extends('layouts.front')

@section('page-title')
    Settings
@endsection

@section('front-content')
    <div class="row">
      <div class="col-md-3">
          @include('settings._partials._nav')
      </div>
      <div class="col-md-9">
          @yield('settings-content')
      </div>
    </div>
@endsection