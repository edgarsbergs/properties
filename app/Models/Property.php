<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use App\Scopes\PropertyScope;

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

    /**
     * Building search
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query)
    {
        // get Request params
        $params = app('Illuminate\Http\Request')->all();

        $search_params = [];
        unset($params['_token']);
        unset($params['save']);

        // build search params
        // @TODO cases for columns where search operator is not '='
        foreach ($params as $column => $value) {
            if ($value) {
                $search_params[$column] = $value;
            }
        }

        return $query->where($search_params);
    }
}
