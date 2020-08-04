<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category1;
use App\Category2;
use App\Category3;


class CategoryController extends Controller
{
    public function index()
    {
        $category1 = Category1::get();
        $category2 = Category2::get();
        $category3 = Category3::get();

        return response()->json(['category1' => $category1, 'category2' => $category2, 'category3' => $category3]);
    }
    public function update(Request $request)
    {
        $type = $request->type;
        $category = $request->data;

        if ($type === 'category1') {
            $Category1 = Category1::where('id', $category['id'])->first();
            $Category1->label = $category['label'];
            if (!empty($category['description'])) {
                $Category1->description = $category['description'];
            }
            if ($category['image'] && $category['image'] !== $Category1['image']) {
                $image = $category['image']; // base64 encoded
                $extension = explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];   // .jpg .png .pdf
                $replace = substr($image, 0, strpos($image, ',') + 1);
                $image = str_replace($replace, '', $image);
                $image = str_replace(' ', '+', $image);
                $imageName = time() . 'C1.' . $extension;
                $path = public_path() . "/images/uploads/" . $imageName;
                $image_decoded = base64_decode($image); // decoding File
                file_put_contents($path, $image_decoded);
                $Category1->image = '/images/uploads/' . $imageName; //full path
            }
            $Category1->icon = $category['icon'];
            $Category1->save();
        }


        if ($type === 'category2') {
            $Category2 = Category2::find($category['id']);
            $Category2->label = $category['label'];
            if (!empty($category['description'])) {
                $Category2->description = $category['description'];
            }
            if ($category['image'] && $category['image'] !== $Category2['image']) {
                $image = $category['image']; // base64 encoded
                $extension = explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];   // .jpg .png .pdf
                $replace = substr($image, 0, strpos($image, ',') + 1);
                $image = str_replace($replace, '', $image);
                $image = str_replace(' ', '+', $image);
                $imageName = time() . 'C2.' . $extension;
                $path = public_path() . "/images/uploads/" . $imageName;
                $image_decoded = base64_decode($image); // decoding File
                file_put_contents($path, $image_decoded);
                $Category2->image = '/images/uploads/' . $imageName; //full path
            }
            $Category2->icon = $category['icon'];
            $Category2->save();
        }

        if ($type === 'category3') {
            $Category3 = Category3::find($category['id']);
            $Category3->label = $category['label'];
            if (!empty($category['description'])) {
                $Category3->description = $category['description'];
            }
            if ($category['image'] && $category['image'] !== $Category3['image']) {
                $image = $category['image']; // base64 encoded
                $extension = explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];   // .jpg .png .pdf
                $replace = substr($image, 0, strpos($image, ',') + 1);
                $image = str_replace($replace, '', $image);
                $image = str_replace(' ', '+', $image);
                $imageName = time() . 'C3.' . $extension;
                $path = public_path() . "/images/uploads/" . $imageName;
                $image_decoded = base64_decode($image); // decoding File
                file_put_contents($path, $image_decoded);
                $Category3->image = '/images/uploads/' . $imageName; //full path
            }
            $Category3->icon = $category['icon'];
            $Category3->save();
        }

        return response()->json('Success');
    }
    public function store(Request $request)
    {
        $data = $request->data;
        $category1 = $data['category1'];
        $category2 = $data['category2'];

        $check = Category1::where('label', $category1['label'])->first();
        if (empty($check)) {
            $Category1 = new Category1();
            $Category1->label = $category1['label'];
            if (!empty($category1['description'])) {
                $Category1->description = $category1['description'];
            }
            if ($category1['image']) {
                $image1 = $category1['image']; // base64 encoded
                $extension1 = explode('/', explode(':', substr($image1, 0, strpos($image1, ';')))[1])[1];   // .jpg .png .pdf
                $replace1 = substr($image1, 0, strpos($image1, ',') + 1);
                $image1 = str_replace($replace1, '', $image1);
                $image1 = str_replace(' ', '+', $image1);
                $imageName1 = time() . 'C1.' . $extension1;
                $path1 = public_path() . "/images/uploads/" . $imageName1;
                $image_decoded1 = base64_decode($image1); // decoding File
                file_put_contents($path1, $image_decoded1);
                $Category1->image = '/images/uploads/' . $imageName1; //full path
            }
            $Category1->icon = $category1['icon'];
            $Category1->save();
            $Category1->value = $Category1->id;
            $Category1->save();

            $Category2 = new Category2();
            $Category2->label = $category2['label'];
            if ($category2['image']) {
                $image2 = $category2['image']; // base64 encoded
                $extension2 = explode('/', explode(':', substr($image2, 0, strpos($image2, ';')))[1])[1];   // .jpg .png .pdf
                $replace2 = substr($image2, 0, strpos($image2, ',') + 1);
                $image2 = str_replace($replace2, '', $image2);
                $image2 = str_replace(' ', '+', $image2);
                $imageName2 = time() . 'C2.' . $extension2;
                $path2 = public_path() . "/images/uploads/" . $imageName2;
                $image_decoded2 = base64_decode($image2); // decoding File
                file_put_contents($path2, $image_decoded2);
                $Category2->image = '/images/uploads/' . $imageName2; //full path
            }
            $Category2->icon = $category2['icon'];
            $Category2->description = $category2['description'];
            $Category2->category1_id = $Category1->id;
            $Category2->save();
            $Category2->value = $Category2->id;
            $Category2->save();
            $Category2_id = $Category2->id;
        } else {
            $check2 = Category2::where('label', $category2['label'])->first();
            if (empty($check2)) {
                $Category2 = new Category2();
                $Category2->label = $category2['label'];
                if (!empty($category2['description'])) {
                    $Category2->description = $category2['description'];
                }
                if ($category2['image']) {
                    $image2 = $category2['image']; // base64 encoded
                    $extension2 = explode('/', explode(':', substr($image2, 0, strpos($image2, ';')))[1])[1];   // .jpg .png .pdf
                    $replace2 = substr($image2, 0, strpos($image2, ',') + 1);
                    $image2 = str_replace($replace2, '', $image2);
                    $image2 = str_replace(' ', '+', $image2);
                    $imageName2 = time() . 'C2.' . $extension2;
                    $path2 = public_path() . "/images/uploads/" . $imageName2;
                    $image_decoded2 = base64_decode($image2); // decoding File
                    file_put_contents($path2, $image_decoded2);
                    $Category2->image = '/images/uploads/' . $imageName2; //full path
                }
                $Category2->icon = $category2['icon'];
                $Category2->category1_id = $check->id;
                $Category2->save();
                $Category2->value = $Category2->id;
                $Category2->save();
                $Category2_id = $Category2->id;
            } else {
                $Category2_id = $check2->id;
            }
        }
        $category = new Category3();
        $category->label = $data['label'];
        $category->icon = $data['icon'];
        if (!empty($data['description'])) {
            $category->description = $data['description'];
        }
        $category->category2_id = $Category2_id;
        if ($data['image']) {
            $image = $data['image']; // base64 encoded
            $extension = explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];   // .jpg .png .pdf
            $replace = substr($image, 0, strpos($image, ',') + 1);
            $image = str_replace($replace, '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = time() . 'C3.' . $extension;
            $path = public_path() . "/images/uploads/" . $imageName;
            $image_decoded = base64_decode($image); // decoding File
            file_put_contents($path, $image_decoded);
            $category->image = '/images/uploads/' . $imageName; //full path
        }
        $category->save();
        $category->value = $category->id;
        $category->save();

        return response($data);
    }
    public function destroy(Request $request)
    {
        $id = $request->id;
        $type = $request->type;
        if ($type === 'category1') {
            Category1::where('id', $id)->delete();
        }
        if ($type === 'category2') {
            Category2::where('id', $id)->delete();
        }
        if ($type === 'category3') {
            Category3::where('id', $id)->delete();
        }
        return response()->json('success');
    }
}
