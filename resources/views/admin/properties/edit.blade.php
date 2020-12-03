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
                   value="@if(!old('county')){{$property->county}}@endif{{ old('county') }}"/>
        </div>

        <div class="form-group">
            <label for="country">Country</label>
            <input required="required" placeholder="Country" type="text" name="country" id="country" class="form-control"
                   value="@if(!old('country')){{$property->country}}@endif{{ old('country') }}"/>
        </div>

        <div class="form-group">
            <label for="country">Town</label>
            <input required="required" placeholder="Town" type="text" name="town" id="town" class="form-control"
                   value="@if(!old('town')){{$property->town}}@endif{{ old('town') }}"/>
        </div>

        <div class="form-group">
            <label for="country">Description (name)</label>
            <textarea required name='country'class="form-control">
              @if(!old('description'))
                    {!! $property->description !!}
                @endif
                {!! old('description') !!}
            </textarea>
        </div>

        <div class="form-group">
            <label for="country">Displayable Address</label>
            <input required="required" placeholder="Address" type="text" name="address" id="address" class="form-control"
                   value="@if(!old('address')){{$property->address}}@endif{{ old('address') }}"/>
        </div>

        <div class="form-group">
            <label for="image">Image</label>
            <input required="required"  type="file" name="image" id="image" class="form-control" />
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
                   value="@if(!old('price')){{$property->price}}@endif{{ old('price') }}"/>
        </div>

        <input type="hidden" name="id" value="{{ $property->id }}">
        <input type="submit" name="save" value="Save">
    </form>
@endsection
