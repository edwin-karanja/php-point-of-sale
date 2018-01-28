
    {{ csrf_field() }}

    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
        <label for="name" class="col-md-4 control-label">Name</label>

        <div class="col-md-8">
            <input id="name" type="text" class="form-control" name="name" value="{{ old('name', isset($category) ? $category->name : '') }}" autofocus>

            @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
        <label for="description" class="col-md-4 control-label">Description</label>

        <div class="col-md-8">
            <textarea name="description" class="form-control" id="description" cols="30" rows="6">{{ old('description', isset($category) ? $category->description : '')}}</textarea>

            @if ($errors->has('description'))
                <span class="help-block">
                    <strong>{{ $errors->first('description') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
            @component('components._button')
                {{ isset($category) ? 'Update' : 'Add' }}
            @endcomponent

            @if (isset($category))
                <a href="{{ route('category.index') }}" class="pull-right btn btn-link">
                        Cancel
                </a>
            @endif
        </div>
    </div>
