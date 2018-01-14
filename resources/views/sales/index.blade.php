@extends('layouts.front')

@section('page-title')
    Sales

    <a href="{{ route('sales.recent') }}" class="btn btn-primary pull-right">
        @svg('icon-menu')
        Recent Sales
    </a>
@endsection

@section('front-content')
    <div class="row">
        <div class="col-md-8">
            <sales-component></sales-component>
            <br>
            <cart-component></cart-component>
        </div>

        <div class="col-md-4">
            <totals-component></totals-component>
        </div>
    </div>
@endsection

@section('styles')
<link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
@endsection
