@extends('layouts.front')

@section('page-title')
    Suppliers - {{ $supplier->name }}
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
                        <th>Contact Info</th>
                        <td>{{ $supplier->contact_info }}</td>
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
                <supplier-contacts :supplier="{{ $supplier }}"></supplier-contacts>
            </div>
        </div>
    </div>


@endsection