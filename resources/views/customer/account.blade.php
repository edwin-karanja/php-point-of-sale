@extends('layouts.front')

@section('page-title')
    {{ $customer->name }} Account
@endsection

@section('front-content')
    <customer-account-overview-component :customer="{{ $customer }}"></customer-account-overview-component>


    <div class="panel panel-default">
        <div class="panel-body">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#profile">Profile</a></li>
                <li><a data-toggle="tab" href="#receipts">Receipts</a></li>
                {{--<li><a data-toggle="tab" href="#graph">Graphs</a></li>--}}

            </ul>

            <div class="tab-content">
                <div id="profile" class="tab-pane fade in active">
                    <customer-profile :customer="{{ $customer }}"></customer-profile>
                </div>
                <div id="receipts" class="tab-pane fade">
                    <customer-account-receipts-component :customer="{{ $customer }}"></customer-account-receipts-component>
                </div>
                {{--<div id="graph" class="tab-pane fade">--}}
                    {{--<customer-monthly-sales :customer="{{ $customer }}"></customer-monthly-sales>--}}
                {{--</div>--}}

            </div>
        </div>
    </div>

@endsection

@section('styles')
    <style>
        .tab-content {
            padding-top: 10px;
        }
    </style>
@stop