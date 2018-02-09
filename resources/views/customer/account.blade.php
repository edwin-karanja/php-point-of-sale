@extends('layouts.front')

@section('page-title')
    {{ $customer->name }} Account
@endsection

@section('front-content')
    <customer-account-overview-component :customer="{{ $customer }}"></customer-account-overview-component>


    <div class="panel panel-default">
        <div class="panel-body">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#home">Receipts</a></li>
                <li><a data-toggle="tab" href="#menu1">Graphs</a></li>
                <li><a data-toggle="tab" href="#menu2">Menu 2</a></li>
                <li><a data-toggle="tab" href="#menu3">Menu 3</a></li>
            </ul>

            <div class="tab-content">
                <div id="home" class="tab-pane fade in active">
                    <customer-account-receipts-component :customer="{{ $customer }}"></customer-account-receipts-component>
                </div>
                <div id="menu1" class="tab-pane fade">
                    <customer-monthly-sales :customer="{{ $customer }}"></customer-monthly-sales>
                </div>
                <div id="menu2" class="tab-pane fade">
                    <p>page 3</p>
                </div>
                <div id="menu3" class="tab-pane fade">
                    <p>page 4</p>
                </div>
            </div>
        </div>
    </div>

@endsection