@extends('layouts.front')

@section('page-title')
    Purchases/Receivings

    <a href="{{ route('sales.recent') }}" class="pull-right">
        <i class="fa fa-bars"></i>
        <b>Recent Purchases</b>
    </a>
@endsection

@section('front-content')
    <div class="row">
        <div class="col-md-8">
            <purchases-component></purchases-component>

            <purchases-cart-component></purchases-cart-component>
        </div>

        <div class="col-md-4">
            <purchases-totals-component></purchases-totals-component>
        </div>
    </div>

@endsection

@section('styles')
<link href="{{ asset('css/daterangepicker.css') }}" rel="stylesheet">
<link href="{{ asset('css/bootstrap-editable.css') }}" rel="stylesheet">
@endsection