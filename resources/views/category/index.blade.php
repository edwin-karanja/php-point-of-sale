@extends('layouts.front')

@section('page-title')
    Categories
@endsection

@section('front-content')
    <div class="row">
        <div class="col-md-6">
            @if (isset($category))
                <form class="form-horizontal" method="POST" action="{{ route('category.update', ['id' => $category->id]) }}">
                    @include('category._form')
                </form>
            @else
                <form class="form-horizontal" method="POST" action="{{ route('category.store') }}">
                    @include('category._form')
                </form>
            @endif
        </div>
        <div class="col-md-6">
            @if (count($categories) > 0)
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>##</th>
                            <th>Name</th>
                            <th>Items Count</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $key => $category)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>
                                    <a href="{{ route('category.edit', $category) }}">{{ $category->name }}</a>
                                </td>
                                <td>{{ $category->items()->count() }}</td>
                                <td>
                                    <a href="{{ route('category.delete', $category) }}"
                                        onclick="event.preventDefault();
                                                    document.getElementById('delete-form').submit();">
                                        Delete
                                    </a>

                                    <form id="delete-form" action="{{ route('category.delete', $category) }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="well well-sm">
                    No Categories defined yet.
                </div>
            @endif
        </div>
    </div>

@endsection