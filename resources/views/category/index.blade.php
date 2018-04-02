@extends('layouts.front')

@section('page-title')
    Categories
@endsection

@section('front-content')
    <datatables title="Category" endpoint="{{ route('ajax.categories.index') }}"></datatables>
@endsection