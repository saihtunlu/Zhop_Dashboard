<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Brand;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::get();
        return response()->json($brands);
    }
    public function store(Request $request)
    {
        $brand = $request->data;
        $Brand = new Brand();
        $Brand->name = $brand['name'];
        $Brand->description = $brand['description'];
        if ($brand['image']) {
            $image = $brand['image']; // base64 encoded
            $extension = explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];   // .jpg .png .pdf
            $replace = substr($image, 0, strpos($image, ',') + 1);
            $image = str_replace($replace, '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = time() . '.' . $extension;
            $path = public_path() . "/images/uploads/" . $imageName;
            $image_decoded = base64_decode($image); // decoding File
            file_put_contents($path, $image_decoded);
            $Brand->image = '/images/uploads/' . $imageName; //full path
        }
        $Brand->save();

        return response($Brand,200, [], JSON_NUMERIC_CHECK);
    }
    public function update(Request $request)
    {
        $brand = $request->data;
        $Brand = Brand::where('id', $brand['id'])->first();
        $Brand->name = $brand['name'];
        $Brand->description = $brand['description'];
        if ($brand['image'] !== $Brand->image) {
            $image = $brand['image']; // base64 encoded
            $extension = explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];   // .jpg .png .pdf
            $replace = substr($image, 0, strpos($image, ',') + 1);
            $image = str_replace($replace, '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = time() . '.' . $extension;
            $path = public_path() . "/images/uploads/" . $imageName;
            $image_decoded = base64_decode($image); // decoding File
            file_put_contents($path, $image_decoded);
            $Brand->image = '/images/uploads/' . $imageName; //full path
        }
        $Brand->save();

        return response()->json('success');
    }
    public function destroy($id)
    {
        Brand::where('id', $id)->delete();
        return response()->json('success');
    }
}
