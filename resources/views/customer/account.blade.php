@extends('layouts.front')

@section('page-title')
    {{ $customer->name }} Account
@endsection

@section('front-content')
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row pl-6 pr-6">
                <h3 class="pull-left">Recent Payment</h3>
                <h3 class="pull-right">Balance Due</h3>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Receipts</div>
                <div class="panel-body">
                    @if ($customer->sales)
                        <table class="table table-striped table-responsive">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Receipt</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Balance</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($customer->sales as $key => $sale)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td><a href="#">rcpt#{{ $sale->id }}</a></td>
                                        <td>{{ $sale->created_at->toDateString() }}</td>
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
                                        <td class="b">{{ $sale->balance_due }}</td>
                                        <td class="b">{{ $sale->sale_total }}</td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6">
        <div class="panel panel-default">
                <div class="panel-heading">Payments</div>
                <div class="panel-body">
                    payments...
                </div>
            </div>
        </div>
    </div>


@endsection