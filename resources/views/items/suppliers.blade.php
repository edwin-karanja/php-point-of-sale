@extends('items._layout')

@section('item-data')
    <div class="row">
        <div class="col-md-6">
            <p class="fs-24">Registered Suppliers</p>
        </div>
        <div class="col-md-6">
            <item-suppliers :item="{{ $item }}"></item-suppliers>
            <!-- <typeahead-suppliers :dataset="{{ $suppliers->pluck('name') }}"></typeahead-suppliers> -->
        </div>
    </div>
    <!-- <hr> -->

    <item-suppliers-list :suppliers="{{ $item->suppliers }}"></item-suppliers-list>

@endsection