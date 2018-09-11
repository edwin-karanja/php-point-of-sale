<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body style="padding-top: 10px">
<div id="app">
    {{--@include('layouts.partials._nav')--}}

    <div class="container-fluid">
        {{--@if( auth()->check())--}}
            {{--@include('components._breadcrumbs')--}}
            {{--<alert-component></alert-component>--}}
            {{--<page-refresh-component></page-refresh-component>--}}
        {{--@endif--}}


        {{--@include('layouts.partials.alerts._alerts')--}}
        @yield('content')
    </div>

</div>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>

<script>
    window.setTimeout(function () {
        $('.alert').fadeTo(500, 0).slideUp(500, function () {
            $(this).remove();
        })
    }, 3000);
</script>

@yield('scripts')
</body>
</html>
