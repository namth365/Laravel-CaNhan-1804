<?php
namespace App\Traits;

use Image;

trait HandleImage
{

    protected $path = 'thumbnail';
    protected $imageDefault = 'image_default.png';

    public function verifyImage($request) : bool
    {
        if ($request->file('image')) {
            return true;
        }
        return false;
    }

    public function storeImage($request) :? string
    {
        if ($this->verifyImage($request)) {
            $image = $request->image;
            $imageExt = $image->getClientOriginalExtension();
            $name = time() . '.' . $imageExt;
            $image->move($this->path, $name);
            return $name;
        }
        return $this->imageDefault;
    }

    public function deleteImage($image)
    {
        $path = $this->path . '/' . $image;
        //kiem tra ton tai
        if (file_exists($path) && $image != $this->imageDefault) {
            //huy lien ket (xoa)
            unlink($path);
        }
    }

    public function updateImage($request, $currentImage)
    {
        if ($this->verifyImage($request)) {
            $this->deleteImage($currentImage);
            return $this->storeImage($request);
        }
        return $currentImage;
    }
}
