<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PropertyController extends Controller
{
    private $properties;
    private $request;
    public $max_bedrooms = 20;
    public $max_bathrooms = 20;
    public $per_page = 15;
    public $deal_types = ['sale', 'rent'];


    /**
     * Save data to DB
     *
     * @param $data
     */
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

    /**
     * Show properties
     *
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $this->request = $request;
        $this->properties = Property::with('propertyType');
        $this->buildSearch();
        $this->properties = $this->properties->paginate($this->per_page);

        $property_types = PropertyType::allTypes();

        return view('admin.properties.index', [
            'properties' => $this->properties,
            'deal_types' => $this->deal_types,
            'property_types' => $property_types,
        ])->withInput($this->request);
    }

    /**
     * Show edit form
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $property = Property::find($id)->first();

        return view('admin.properties.edit', [
            'property' => $property,
            'max_bedrooms' => $this->max_bedrooms,
            'max_bathrooms' => $this->max_bathrooms,
        ]);
    }


    /**
     * Update property
     *
     * @param Request $request
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $property = Property::find($request->id);
        $values = $request->validate([
            'country' => 'required',
            'county' => 'required',
            'town' => 'required',
            'address' => 'required',
            'num_bedrooms' => 'required',
            'num_bathrooms' => 'required',
            'price' => 'required',
        ]);

        // image
        if ($request->image) {
            $image_controller = new ImageController;
            $image = $image_controller->upload($request->image);

            if (in_array($image, ['not_valid_image'])) {
                $errors = 'Problems uploading image';
            } else {
                $values['image'] = $image;
            }
        }

        $property->save($values);
        $message = 'Updated!';

        $redirect = redirect(route('admin.property', $request->id))->withMessage($message);
        if ($errors) {
            $redirect->withErrors($errors);
        }

        return $redirect;
    }


    /**
     * If search form is submitted add additional Eloquent rules
     */
    public function buildSearch()
    {
        // GET doesnt contain search parameters so no need for search results
        if ($this->request->isMethod('get')) {
            return true;
        }

        if ($this->request->description) {
            $this->properties = $this->properties->where('description', 'LIKE', '%' . $this->request->description . '%');
        }

        if ($this->request->num_bedrooms) {
            $this->properties = $this->properties->where('num_bedrooms', '=', $this->request->num_bedrooms);
        }

        if ($this->request->price) {
            $this->properties = $this->properties->where('price', '=', $this->request->price);
        }

        if ($this->request->type) {
            $this->properties = $this->properties->where('type', '=', $this->request->type);
        }

        if ($this->request->property_type_id) {
            $this->properties = $this->properties->where('property_type_id', '=', $this->request->property_type_id);
        }
    }
}
