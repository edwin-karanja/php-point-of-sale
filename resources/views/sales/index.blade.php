@extends('layouts.front')

@section('page-title')
    Sales

    <a href="{{ route('sales.recent') }}" class="pull-right">
        <i class="fa fa-bars"></i>
        <b>Recent Sales</b>
    </a>
@endsection

@section('front-content')
    <div class="row">
        <div class="col-md-8">
            <sales-component></sales-component>

            <cart-component></cart-component>
        </div>

        <div class="col-md-4">
            <totals-component></totals-component>
        </div>
    </div>
@endsection
