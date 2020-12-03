<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyType;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function save($data)
    {
        foreach ($data as $property) {
            // create or update property type
            $property_type = $property['property_type'];
            PropertyType::updateOrCreate($property_type);

            // create or update property
            unset($property['property_type']);
            Property::updateOrCreate($property);
        }
    }
}
