@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <b>@yield('page-title')</b>
                </div>

                <div class="panel-body">
                    @yield('front-content')
                </div>
            </div>

        </div>
    </div>


@endsection