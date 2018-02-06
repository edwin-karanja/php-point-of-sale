@extends('layouts.front')

@section('page-title')
    Suppliers - {{ strtoupper($supplier->name) }}

    <span class="pull-right">
        Last supply date: {{ $supplier->last_supply_date ? $supplier->last_supply_date->toFormattedDateString() : '-' }}
    </span>
@endsection

@section('front-content')
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <b>Contact - Info</b>

                    <a href="#" class="pull-right">
                        <i class="fa fa-plus"></i>
                        <b>Add</b>
                    </a>
                </div>
                <div class="panel-body">
                    No supplier contacts added yet. <a href="#">Add contact?</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <b>Stats</b>
                </div>
                <div class="panel-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th>Transactions</th>
                                <td>
                                    <span class="label label-primary">
                                    {{ $supplier->purchases->count() }} {{ str_plural('transaction', $supplier->purchases->count()) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Transactions Totals</th>
                                <td class="b">Kshs. {{ $supplier->total_supplied_amount }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4 pull-right">
            <banking-component :supplier="{{ json_encode($supplier) }}"></banking-component>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <b>Contact - Notes</b>

                    <a href="#" class="pull-right">
                        <i class="fa fa-plus"></i>
                        <b>Add</b>
                    </a>
                </div>
                <div class="panel-body">
                    Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quod delectus autem, illum nisi tenetur culpa sit repudiandae ipsam sed optio veritatis numquam natus labore quae cupiditate nostrum quia dicta! Distinctio.
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <b>Supplier - Supplies</b>

                    <a href="#" class="pull-right">
                        <i class="fa fa-plus"></i>
                        <b>Add</b>
                    </a>
                </div>
                <div class="panel-body">
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit praesentium earum ipsum fugiat aliquid tempore, laboriosam ipsa vel perspiciatis? Necessitatibus quasi debitis sit fugit illum iure sunt, atque ipsa sed.</p>
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Vero odit illum iusto modi atque, reprehenderit quae quod suscipit doloribus vitae! Quidem dolor culpa repellendus nesciunt dicta odio in fugiat voluptatibus.</p>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quod minus odit nam in minima numquam fugit quae, impedit tempora, quos corporis voluptatem voluptate veritatis neque ab sed eius delectus tempore?</p>
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Dicta nulla distinctio est, ab suscipit numquam asperiores repellendus reiciendis ipsam, dignissimos eveniet at, molestiae cupiditate laborum accusamus similique perferendis dolore praesentium!</p>
                </div>
            </div>
        </div>
    </div>

@endsection