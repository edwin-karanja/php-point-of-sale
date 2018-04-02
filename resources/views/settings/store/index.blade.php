@extends('settings._layout')

@section('page-title')
    Settings\Store
@endsection

@section('settings-content')
    <div class="row">
        <div class="col-md-8">
            <form method="POST" class="form-horizontal" action="{{ route('settings.store.store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="name" class="col-md-4 control-label">Store Name</label>

                    <div class="col-md-8">
                        <input id="name" type="text" class="form-control" name="name" value="{{ old('name', $store->name) }}" required autofocus>

                        @if ($errors->has('name'))
                            <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                        @endif
                    </div>

                </div>

                <div class="form-group{{ $errors->has('short_name') ? ' has-error' : '' }}">
                    <label for="name" class="col-md-4 control-label">Store Short Name</label>

                    <div class="col-md-8">
                        <input id="short_name" type="text" class="form-control" name="short_name" value="{{ old('short_name', $store->short_name) }}" required autofocus>
                        <small id="emailHelp" class="form-text text-muted">This is a short name for the company, incase the company name is too long.</small>

                        @if ($errors->has('short_name'))
                            <span class="help-block">
                        <strong>{{ $errors->first('short_name') }}</strong>
                    </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('picture') ? ' has-error' : '' }}">
                    <label for="name" class="col-md-4 control-label">Picture</label>

                    <div class="col-md-8">
                        <input id="picture" type="file" class="form-control" name="picture">

                        @if ($errors->has('picture'))
                            <span class="help-block">
                        <strong>{{ $errors->first('picture') }}</strong>
                    </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('location') ? ' has-error' : '' }}">
                    <label for="email" class="col-md-4 control-label">Location</label>

                    <div class="col-md-8">
                        <input id="location" type="text" class="form-control" name="location" value="{{ old('location', $store->location) }}">
                        <small class="form-text text-muted">This is the current location of the store.</small>

                        @if ($errors->has('location'))
                            <span class="help-block">
                        <strong>{{ $errors->first('location') }}</strong>
                    </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                    <label for="email" class="col-md-4 control-label">Store Address/P.O.Box</label>

                    <div class="col-md-8">
                        <input id="address" type="text" class="form-control" name="address" value="{{ old('address', $store->address) }}">
                        <small class="form-text text-muted">This is the address of the store/business.</small>

                        @if ($errors->has('address'))
                            <span class="help-block">
                    <strong>{{ $errors->first('address') }}</strong>
                </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('timezone') ? ' has-error' : '' }}">
                    <label for="timezone" class="col-md-4 control-label">Timezone</label>

                    <div class="col-md-8">
                        <select name="timezone" id="timezone" class="form-control">
                            <option value="">-- Choose Your timezone --</option>
                            <option value="Africa\Nairobi" {{ old('timezone', $store->timezone) == 'Africa\Nairobi' ? 'selected' : '' }}>Africa\Nairobi</option>
                        </select>
                        <small class="form-text text-muted">This timezone will be used in generating reports as well as displaying time within the system.</small>

                        @if ($errors->has('timezone'))
                            <span class="help-block">
                        <strong>{{ $errors->first('timezone') }}</strong>
                    </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                    <label for="tax_percent" class="col-md-4 control-label">Tax Percent</label>

                    <div class="col-md-8">
                        <input id="tax_percent" type="text" class="form-control" name="tax_percent" value="{{ old('tax_percent', $store->tax_percent) }}">
                        <small class="form-text text-muted">The default tax percent. If not configured, 16% VAT will be used.</small>

                        @if ($errors->has('tax_percent'))
                            <span class="help-block">
                        <strong>{{ $errors->first('tax_percent') }}</strong>
                    </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('receipt_contents') ? ' has-error' : '' }}">
                    <label for="receipt_contents" class="col-md-4 control-label">Receipt Contents</label>

                    <div class="col-md-8">
                        <textarea name="receipt_contents" class="form-control" id="receipt_contents" cols="30" rows="4">{{ old('receipt_contents', $store->receipt_contents) }}</textarea>
                        <small class="form-text text-muted">The contents displayed at the bottom of a receipt.</small>

                        @if ($errors->has('receipt_contents'))
                            <span class="help-block">
                        <strong>{{ $errors->first('receipt_contents') }}</strong>
                    </span>
                        @endif
                    </div>
                </div>



                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-plus"></i>
                            Save Configurations
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-md-4">
            <div class="thumbnail">
                @if ($store->hasMedia('store-image'))
                    <img class="img-rounded" src="{{ $store->getMedia('store-image')->first()->getUrl() }}">

                    <div class="caption">
                        <p>Store image.</p>
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection