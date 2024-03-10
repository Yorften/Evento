<?php

namespace App\Traits;

use App\Models\Image;

trait ImageUpload
{
    public function storeFakeImg($url, object $obj)
    {
        $imageContents = file_get_contents($url);

        $imageName = time() . '_' . uniqid() . '.png';

        file_put_contents(public_path('storage/' . $imageName), $imageContents);

        Image::create([
            "path" => $imageName,
            "imageable_id" => $obj->id,
            "imageable_type" => get_class($obj)
        ]);
    }

    public function storeImg($image, object $obj)
    {
        $imageName = $this->move($image);
        Image::create([
            "path" => $imageName,
            "imageable_id" => $obj->id,
            "imageable_type" => get_class($obj)
        ]);
    }
    public function upadateImg($image, object $obj)
    {
        $imageName = $this->move($image);
        $obj->image()->update(["path" => $imageName]);
    }
    public function move($image)
    {
        $imageName = time() . '_' . uniqid() . '.' . $image->extension();
        $image->storeAs('public/', $imageName);
        return $imageName;
    }
}
