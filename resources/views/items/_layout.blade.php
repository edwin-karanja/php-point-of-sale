@extends('layouts.front')

@section('page-title')
    Product - {{ ucwords( $item->name ) }}

    <a href="/items" class="btn btn-success btn-sm pull-right">Products Listing</a>
@endsection

@section('front-content')
    <div class="row">
        <div class="col-md-8">
            @yield('item-data')
        </div>
        <div class="col-md-4">
            @include('items._nav')
        </div>
    </div>

@endsection