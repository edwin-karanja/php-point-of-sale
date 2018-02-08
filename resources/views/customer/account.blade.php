@extends('layouts.front')

@section('page-title')
    {{ $customer->name }} Account
@endsection

@section('front-content')
    <customer-account-overview-component :customer="{{ $customer }}"></customer-account-overview-component>

    <div class="row">
        <div class="col-md-7">
            <customer-account-receipts-component :customer="{{ $customer }}"></customer-account-receipts-component>
        </div>

        <div class="col-md-5">
            <customer-monthly-sales :customer="{{ $customer }}"></customer-monthly-sales>
        </div>
    </div>

@endsection