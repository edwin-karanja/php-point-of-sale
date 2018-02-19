@extends('layouts.front')

@section('page-title')
    Suppliers - {{ $supplier->name }}

    <span class="pull-right">
        Last supply date - {{ $supplier->last_supply_date ? $supplier->last_supply_date->toDateString() : '-' }}
    </span>
@endsection

@section('front-content')
    <div class="row">
        <div class="col-md-6">
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <th>Name</th>
                        <td>{{ $supplier->name }}</td>
                    </tr>
                    <tr>
                        <th>Vat PIN</th>
                        <td>{{ $supplier->vat_pin }}</td>
                    </tr>
                    <tr>
                        <th>Last supply date</th>
                        <td>{{ $supplier->last_supply_date }}</td>
                    </tr>
                    <tr>
                        <th>Totals</th>
                        <td>{{ $supplier->total_supplied_amount }}</td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td>{{ $supplier->description }}</td>
                    </tr>
                </tbody>
            </table>
            <button class="btn btn-primary">Edit details</button>
        </div>
        <div class="col-md-6">


            <div class="col-md-12">
                <supplier-bankings :supplier="{{ $supplier }}"></supplier-contacts>
            </div>

            <div class="col-md-12">
                <supplier-contacts :supplier="{{ $supplier }}"></supplier-contacts>
            </div>

        </div>
    </div>


@endsection