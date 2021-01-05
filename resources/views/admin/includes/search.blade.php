<form action="{{ route('admin.propertiesSearch') }}" method="POST">
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="description">Name (exact match)</label>
                <input placeholder="name" type="text" v-model="search.description" name="description" id="description" class="form-control" value="{{ $request->description }}"/>
            </div>
        </div>

        <div class="col">
            <div class="form-group">
                <label for="num_bedrooms">Number of Bedrooms</label>
                <input placeholder="Bedrooms" type="number" v-model="search.num_bedrooms" name="num_bedrooms" id="num_bedrooms" class="form-control" value="{{ $request->num_bedrooms }}"/>
            </div>
        </div>

        <div class="col">
            <div class="form-group">
                <label for="price">Price</label>
                <input placeholder="Price" type="number" v-model="search.price" name="price" id="price" class="form-control" value="{{ $request->price }}"/>
            </div>
        </div>

        <div class="col">
            <div class="form-group">
                <label for="type">Property type</label>
                <select name="property_type_id" id="property_type_id" class="form-control" v-model="search.property_type_id">
                    <option value=""></option>
                    @foreach ($data['property_types'] as $property_type)
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
