@extends('layouts.front')

@section('page-title')
    Manage Inventory
@endsection

@section('front-content')
    <div class="row">
        <div class="col-md-4">

            <inventory-items-component></inventory-items-component>

        </div>
        <div class="col-md-8">

            <inventory-history-component></inventory-history-component>

        </div>
    </div>

@endsection