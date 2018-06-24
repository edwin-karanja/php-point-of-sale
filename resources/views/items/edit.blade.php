@extends('items._layout')

@section('item-data')
    <form action="{{ route('item.update', [$item->id]) }}" method="post">
        <h1>Product Properties</h1>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    <label for="" class="control-label">Name</label>
                    <input type="text" name="name" value="{{ old('name', $item->name) }}" class="form-control">

                    @if ($errors->has('name'))
                        <span class="help-block">
                            {{ $errors->first('name') }}
                        </span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="" class="control-label">Description</label>
                    <textarea name="description" id="" cols="30" rows="10" class="form-control">{{ old('description', $item->description) }}</textarea>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group {{ $errors->has('buying_price') ? 'has-error' : '' }}">
                    <label for="" class="control-label">Buying Price</label>
                    <input type="number" name="buying_price" value="{{ old('buying_price', $item->buying_price) }}" class="form-control">

                    @if ($errors->has('buying_price'))
                        <span class="help-block">
                            {{ $errors->first('buying_price') }}
                        </span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('selling_price') ? 'has-error' : '' }}">
                    <label for="" class="control-label">Selling Price</label>
                    <input type="number" name="selling_price" class="form-control" value="{{ old('selling_price', $item->selling_price) }}">

                    @if ($errors->has('selling_price'))
                        <span class="help-block">
                            {{ $errors->first('selling_price') }}
                        </span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('reorder_level') ? 'has-error' : '' }}">
                    <label for="" class="control-label">Re-order Level</label>
                    <input type="number" name="reorder_level" class="form-control" value="{{ old('reorder_level', $item->reorder_level) }}">

                    @if ($errors->has('reorder_level'))
                        <span class="help-block">
                            {{ $errors->first('reorder_level') }}
                        </span>
                    @endif
                </div>

                <div class="form-group {{ $errors->has('category_id') ? 'has-error' : '' }}">
                    <label for="" class="control-label">Category</label>
                    <select name="category_id" id="" class="form-control">
                        <option value=""> -- Select Category --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $item->category_id) == $category->id ? 'selected' : '' }}>{{ ucwords( $category->name ) }}</option>
                        @endforeach
                    </select>

                    @if ($errors->has('category_id'))
                        <span class="help-block">
                            {{ $errors->first('category_id') }}
                        </span>
                    @endif
                </div>

                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="show_on_listing" {{ old('show_on_listing') ? 'checked' : '' }}> Show on Listing
                        </label>
                    </div>
                </div>
                {{ csrf_field() }}
            </div>

        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-save"></i>
                Update Item
            </button>
        </div>
    </form>
@endsection