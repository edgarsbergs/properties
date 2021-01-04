<?php

namespace App;

use Illuminate\Http\Request;
use App\Http\Requests;
use Image;

class ImageHelper
{

    private $image;
    public $width = 100;
    public $height = 100;
    public $file_types = ['jpg', 'jpeg', 'png', 'bmp', 'gif'];
    public $file_name; // new file name
    public $images_location = '/images';
    public $images_thumbs_location = '/images/thumbs';

    /**
     * Uploads and resizes image
     *
     * @return string
     * @throws \Illuminate\Validation\ValidationException
     */
    public function upload($image)
    {
        $this->image = $image;
        if (!$this->validateImage()) {
            return 'not_valid_image';
        }
        $this->file_name = $image->getClientOriginalName();

        // put uploaded image
        $orig_image = Image::make($image->path());
        $orig_image->save(public_path($this->images_location) . '/'. $this->file_name);

        $this->resizeImage($this->image->path());

        return $this->file_name;
    }

    /**
     * Resizes image
     */
    public function resizeImage($image_path)
    {
        $img = Image::make($image_path);
        $img->resize($this->width, $this->height, function ($constraint) {
            $constraint->aspectRatio();
        })->save(public_path($this->images_thumbs_location) . '/' . $this->file_name);
    }

    /**
     * Validates image
     *
     * @return bool
     */
    public function validateImage()
    {
        $extension = $this->image->getClientOriginalExtension();
        if (!in_array($extension, $this->file_types)) {
            return false;
        }

        return true;
    }
}
