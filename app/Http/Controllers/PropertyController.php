<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyType;
use Illuminate\Http\Request;


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

            // skip update if property manually updated
            $manual_action = Property::where('uuid', $property['uuid'])->value('manual_action');
            if ($manual_action > 0){
                continue;
            }

            Property::updateOrCreate([
                'uuid' => $property['uuid'],
            ], $property);
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
        $this->properties = Property::with("propertyType");
            #->where('manual_action','<>','1');
        $this->buildSearch();
        $this->properties = $this->properties->paginate($this->per_page);

        $property_types = PropertyType::allTypes();

        return view('admin.properties.index', [
            'properties' => $this->properties,
            'deal_types' => $this->deal_types,
            'property_types' => $property_types,
            'request' => $request,
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
        $property = Property::find($id);

        return view('admin.properties.edit', [
            'property' => $property,
            'max_bedrooms' => $this->max_bedrooms,
            'max_bathrooms' => $this->max_bathrooms,
            'deal_types' => $this->deal_types,
            'property_types' => PropertyType::allTypes(),
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
            'num_bedrooms' => 'required|numeric',
            'num_bathrooms' => 'required|numeric',
            'price' => 'required|numeric',
            'property_type_id' => 'required|numeric',
        ]);

        // image
        if ($request->image) {
            $image_controller = new ImageController;
            $image = $image_controller->upload($request->image);

            if (in_array($image, ['not_valid_image'])) {
                $errors = 'Problems uploading image';
            } else {
                // assuming filenames are exact, but locations are different
                $values['image_full'] = $image;
                $values['image_thumbnail'] = $image;
            }
        }

        // property is manually edited
        $values['manual_action'] = 2;

        if ($property->update($values)) {
            $message = 'Updated!';
        }

        $redirect = redirect(route('admin.property', $request->id))->withMessage($message);
        if (isset($errors)) {
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


    /**
     *
     *
     * @param $id property id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete($id)
    {
        $property = Property::find($id);
        $result = $property->update([
            'manual_action' => '1', //deleted
        ]);

        if ($result) {
            return redirect(route('admin.properties'))->withMessage('Property deleted');
        } else {
            return redirect(route('admin.properties'))->withErrors('Couldnt delete');
        }
    }
}
