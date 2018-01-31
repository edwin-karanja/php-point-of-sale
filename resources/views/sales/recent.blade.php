@extends('layouts.front')

@section('page-title')
    Recent Sales

    <a href="{{ route('sales.index') }}" class="pull-right">
        <i class="fa fa-shopping-cart"></i>
        <b>Sales Register</b>
    </a>
@endsection

@section('front-content')
    <div class="panel panel-default">

        <div class="panel-body">
            <p><b>Filters</b></p>
            <p><b>More filters</b></p>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
            <table class="table table-bordered table-striped table-condensed">
                <thead>
                    <tr>
                        <th>##</th>
                        <th>Sale ID</th>
                        <th>Transaction Status</th>
                        <th>User</th>
                        <th>Customer</th>
                        <th>Payment</th>
                        <th>Total</th>
                        <th>Balance</th>
                        <th>Mpesa Ref#</th>
                        <th>Product Count</th>
                        <td>Transaction Date</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sales as $key => $sale)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td><a href="#">{{ $sale->id }}</a></td>
                            <td>
                                 @if ($sale->payment_status == 'FULLY PAID')
                                    <span class="label label-success">
                                        {{ $sale->payment_status }}
                                    </span>
                                @elseif ($sale->payment_status == 'PARTIALLY PAID')
                                    <span class="label label-warning">
                                        {{ $sale->payment_status }}
                                    </span>
                                @else
                                    <span class="label label-danger">
                                        {{ $sale->payment_status }}
                                    </span>
                                @endif
                            </td>
                            <td><a href="#">{{ $sale->user->name }}</a></td>
                            <td><a href="{{ route('customer.account', $sale->customer) }}">{{ $sale->customer->name }}</a></td>
                            <td>
                                @if ($sale->payment_mode == 'cash')
                                    <span class="label label-primary">
                                        {{ $sale->payment_mode }}
                                    </span>
                                @elseif ($sale->payment_mode == 'oncredit')
                                    <span class="label label-warning">
                                        {{ $sale->payment_mode }}
                                    </span>
                                @else
                                    <span class="label label-success">
                                        {{ $sale->payment_mode }}
                                    </span>
                                @endif
                            </td>
                            <td class="b">{{ $sale->sale_total }}</td>
                            <td class="b">{{ $sale->balance_due }}</td>
                            <td>{{ $sale->mpesa_ref_no }}</td>
                            <td><span class="badge">{{ $sale->items_count }}</span></td>
                            <td>{{ $sale->created_at->toDayDateTimeString() }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $sales->links() }}
        </div>
    </div>
@endsection
