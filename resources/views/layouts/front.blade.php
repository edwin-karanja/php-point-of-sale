@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-md-2">
            @include('layouts.partials.side_nav')
        </div>
        <div class="col-md-10">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">@yield('page-title')</div>

                <div class="panel-body">
                    @yield('front-content')
                </div>
            </div>

        </div>
    </div>


@endsection