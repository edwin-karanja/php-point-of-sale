@extends('layouts.front')

@section('page-title')
    Recent Sales

    <a href="{{ route('sales.index') }}" class="btn btn-primary pull-right">
        @svg('icon-cart')
        Sales Register
    </a>
@endsection

@section('front-content')
    <div class="panel panel-default">

        <div class="panel-body">
            Filters
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>##</th>
                        <th>Sale ID</th>
                        <th>Invoice No#</th>
                        <th>Delivery No#</th>
                        <th>User</th>
                        <th>Customer</th>
                        <th>Payment</th>
                        <th>Total</th>
                        <th>Mpesa Ref#</th>
                        <td>Transaction Date</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sales as $key => $sale)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td><a href="#">{{ $sale->id }}</a></td>
                            <td>{{ $sale->invoice_number or '-'  }}</td>
                            <td>{{ $sale->delivery_number or '-' }}</td>
                            <td><a href="#">{{ $sale->user->name }}</a></td>
                            <td><a href="#">{{ $sale->customer->name }}</a></td>
                            <td>
                                @if ($sale->payment_mode == 'cash')
                                    <span class="label label-primary">
                                        {{ $sale->payment_mode }}
                                    </span>
                                @else
                                    <span class="label label-success">
                                        {{ $sale->payment_mode }}
                                    </span>
                                @endif
                            </td>
                            <td class="b">Kshs. {{ $sale->sale_total }}</td>
                            <td>{{ $sale->mpesa_ref_no }}</td>
                            <td>{{ $sale->created_at->toDayDateTimeString() }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $sales->links() }}
        </div>
    </div>
@endsection
