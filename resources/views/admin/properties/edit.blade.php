@extends('layouts.default')

@section('meta_title')
    Property
@endsection

@section('content')
    <form method="post" action='{{ route("admin.updateProperty") }}' enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="county">County</label>
            <input required="required" placeholder="County" type="text" name="county" id="county" class="form-control"
                   value="{{ old('county', $property->county) }}"/>
        </div>

        <div class="form-group">
            <label for="country">Country</label>
            <input required="required" placeholder="Country" type="text" name="country" id="country" class="form-control"
                   value="{{ old('country', $property->country) }}"/>
        </div>

        <div class="form-group">
            <label for="country">Town</label>
            <input required="required" placeholder="Town" type="text" name="town" id="town" class="form-control"
                   value="{{ old('town', $property->town) }}"/>
        </div>

        <div class="form-group">
            <label for="country">Description (name)</label>
            <textarea required name='description'class="form-control">{{ old('description', $property->description) }}
            </textarea>
        </div>

        <div class="form-group">
            <label for="country">Displayable Address</label>
            <input required="required" placeholder="Address" type="text" name="address" id="address" class="form-control"
                   value="{{ old('description', $property->description) }}"/>
        </div>

        <div class="row">
            <div class="col col-1 col-sm-2">
                @if($property->image_thumbnail)
                    <img src="{{ '/images/thumbs/' . $property->image_thumbnail }}" alt="image" />
                @endif
            </div>
            <div class="col col-11 col-sm-10">
                <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" name="image" id="image" class="form-control" />
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="num_bedrooms">Number of Bedrooms</label>
            <select name="num_bedrooms" id="num_bedrooms" class="form-control">
                <option value=""></option>
                @include('admin.includes.options', [
                    'current_value' => $property->num_bedrooms,
                    'max_value' => $max_bedrooms,
                ])
            </select>
        </div>

        <div class="form-group">
            <label for="num_bathrooms">Number of Bathrooms</label>
            <select name="num_bathrooms" id="num_bathrooms" class="form-control">
                <option value=""></option>
                @include('admin.includes.options', [
                    'current_value' => $property->num_bathrooms,
                    'max_value' => $max_bathrooms,
                ])
            </select>
        </div>

        <div class="form-group">
            <label for="country">Price</label>
            <input required="required" placeholder="Price" type="text" name="price" id="price" class="form-control"
                   value="{{ old('price', $property->price) }}"/>
        </div>

        <div class="form-group">
            @foreach ($deal_types as $deal_type)
                <label for="{{ $deal_type }}">{{ $deal_type }}</label>
                <input type="radio" id="{{ $deal_type }}" name="type" value="{{ $deal_type }}"
                    @if($deal_type == $property->type) checked @endif />
            @endforeach
        </div>

        <div class="form-group">
            <label for="num_bathrooms">Property type</label>
            <select name="property_type_id" id="property_type_id" class="form-control">
                <option value=""></option>
                @foreach($property_types as $type)
                    <option value="{{ $type->id }}"
                        @if($type->id == $property->property_type_id) selected @endif />
                        {{ $type->title }}</option>
                @endforeach
            </select>
        </div>

        <input type="hidden" name="id" value="{{ $property->id }}">
        <input type="submit" name="save" value="Save" class="btn btn-success">
    </form>
@endsection
