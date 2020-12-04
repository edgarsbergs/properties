<a href="{{ route('admin.property', $property->id) }}">{{ $property->description }}</a>
<div>
    <span>Bedrooms: {{ $property->num_bedrooms }},</span>
    <span>Price: {{ $property->price }},</span>
    <span>Type: {{ $property->type }},</span>
    <span>Property type: {{ $property->propertyType->title }}</span>
</div>
<form action="{{ route('admin.deleteProperty', $property->id) }}" method="POST">
    @csrf
    <input type="submit" value="Delete" class="btn btn-danger"/>
</form>
