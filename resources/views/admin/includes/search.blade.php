<form action="{{ route('admin.propertiesSearch') }}" method="POST">
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="description">Name</label>
                <input placeholder="name" type="text" name="description" id="description" class="form-control" value="{{ $request->description }}"/>
            </div>
        </div>

        <div class="col">
            <div class="form-group">
                <label for="num_bedrooms">Number of Bedrooms</label>
                <input placeholder="Bedrooms" type="number" name="num_bedrooms" id="num_bedrooms" class="form-control" value="{{ $request->num_bedrooms }}"/>
            </div>
        </div>

        <div class="col">
            <div class="form-group">
                <label for="price">Price</label>
                <input placeholder="Price" type="number" name="price" id="price" class="form-control" value="{{ $request->price }}"/>
            </div>
        </div>

        <div class="col">
            <div class="form-group">
                <label for="type">Type</label>
                <select name="type" id="type" class="form-control">
                    <option value=""></option>
                    @foreach ($deal_types as $type)
                        <option value="{{ $type }}">{{ $type }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col">
            <div class="form-group">
                <label for="type">Property type</label>
                <select name="property_type_id" id="property_type_id" class="form-control">
                    <option value=""></option>
                    @foreach ($property_types as $property_type)
                        <option value="{{ $property_type->id }}" @php if($request->property_type_id == $property_type->id) {echo 'selected';} @endphp>
                            {{ $property_type->title }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    @csrf
    <input type="submit" value="Search" name="save"/>
</form>
