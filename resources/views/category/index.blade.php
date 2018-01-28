@extends('layouts.front')

@section('page-title')
    Categories
@endsection

@section('front-content')
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-body">
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
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-body">
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
                                @foreach($categories as $key => $cat)
                                    <tr class="{{ isset($category) && $category->id === $cat->id ? 'active2' : '' }}">
                                        <td>{{ ++$key }}</td>
                                        <td>
                                            <a href="{{ route('category.edit', $cat) }}">{{ $cat->name }}</a>
                                        </td>
                                        <td>{{ $cat->items()->count() }}</td>
                                        <td>
                                            <a href="{{ route('category.delete', $cat) }}"
                                                onclick="event.preventDefault();
                                                            document.getElementById('delete-form').submit();">
                                                Delete
                                            </a>

                                            <form id="delete-form" action="{{ route('category.delete', $cat) }}" method="POST" style="display: none;">
                                                {{ csrf_field() }}
                                            </form>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $categories->links() }}
                    @else
                        <div class="well well-sm">
                            No Categories defined yet.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection