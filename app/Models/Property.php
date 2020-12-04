<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $guarded = [];

    
    /**
     * Property has property type
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function propertyType()
    {
        return $this->hasOne('App\Models\PropertyType', 'id', 'property_type_id');
    }
}
