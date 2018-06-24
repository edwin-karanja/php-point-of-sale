@extends('items._layout')

@section('item-data')
    <div class="row">
        <div class="col-md-6">
            <h3>Registered Suppliers</h3>
        </div>
        <div class="col-md-6">
            <item-suppliers :item="{{ $item }}"></item-suppliers>
        </div>
    </div>
    <hr>

@endsection