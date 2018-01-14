@extends('layouts.front')

@section('page-title')
    Purchases/Receivings
@endsection

@section('front-content')
    <div class="row">
        <div class="col-md-8">
            <purchases-component></purchases-component>
            <br>
            <purchases-cart-component></purchases-cart-component>
        </div>

        <div class="col-md-4">

        </div>
    </div>

@endsection