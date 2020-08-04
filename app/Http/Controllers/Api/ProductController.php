<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\ProductCategoried;
use App\Category1;
use App\ProductImage;
use App\Tag;
use App\Tagged;
use App\Attribute;
use App\AttributeDetail;
use App\Variation;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('images', 'variations.Attri2.attribute', 'variations.Attri1.attribute', 'brand', 'categories', 'tags.tag')->orderBy('created_at', 'desc')->get();
        return response()->json($products);
    }

    public function addAttribute(Request $request)
    {
        $attributes = $request->data;
        $product_no = $request->product_no;
        Attribute::where('product_no', $product_no)->delete();
        foreach ($attributes as $key => $data) {
            $Attribute = new Attribute();
            $Attribute->name = $data['title'];
            $Attribute->type = $data['type'];
            $Attribute->product_no = $product_no;
            $Attribute->save();
            foreach ($data['details'] as $key => $value) {
                $AttributeDetail = new AttributeDetail();
                $AttributeDetail->name = $value['name'];
                $AttributeDetail->color = $value['color'];
                if ($value['image']) {
                    if (preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', 'images/uploads/1596034943Avatar.jpg')) {
                        $AttributeDetail->image = $value['image'];
                    } else {
                        $image = $value['image']; // base64 encoded
                        $extension = explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];   // .jpg .png .pdf
                        $replace = substr($image, 0, strpos($image, ',') + 1);
                        $image = str_replace($replace, '', $image);
                        $image = str_replace(' ', '+', $image);
                        $imageName = time() . $key . '.' . $extension;
                        $path = public_path() . "/images/uploads/" . $imageName;
                        $image_decoded = base64_decode($image); // decoding File
                        file_put_contents($path, $image_decoded);
                        $AttributeDetail->image = '/images/uploads/' . $imageName; //Profile Image For Employee
                    }
                }
                $AttributeDetail->attribute_id = $Attribute->id;
                $AttributeDetail->save();
            }
        }
        return response()->json('Success');
    }

    public function getAttri($id)
    {
        $Attribute = Attribute::with('details')->where('product_id', $id)->get();
        return response()->json($Attribute);
    }
    public function show($id)
    {
        $product = Product::where('id', $id)->with('images', 'variations.Attri2.attribute', 'variations.Attri1.attribute', 'brand', 'categories', 'tags.tag')->first();
        return response()->json($product);
    }
    public function variations($no)
    {
        $Attribute = Attribute::where('product_no', $no)->with('details')->get();
        return response()->json($Attribute);
    }
    public function store(Request $request)
    {
        $product = json_decode($request->product);
        $Product = new Product();
        $Product->title = $product->title;
        $Product->product_no = $product->product_no;
        $Product->short_description = $product->short_description;
        $Product->long_description = $product->long_description;
        $Product->type = $product->type;
        $Product->brand_id = $product->brand_id;
        $Product->stock = $product->stock;
        $Product->number_of_stock = $product->number_of_stock;
        $Product->threshold = $product->threshold;
        $Product->weight = $product->weight;
        $Product->height = $product->height;
        $Product->width = $product->width;
        $Product->video_link = $product->video_link;
        $Product->discount = $product->discount;
        $Product->regular_price = $product->regular_price;
        $Product->sale_price = $product->sale_price;
        $Product->save();


        $categories = $product->categories;
        foreach ($categories as $key => $data) {
            $add = new ProductCategoried();
            $add->Product_id = $Product->id;
            $add->category1_id = $data[0];
            $add->category2_id = $data[1];
            $add->category3_id = $data[2];
            $add->save();
        }
        $tags = $product->tags;
        foreach ($tags as $key => $data) {
            $check_tag = Tag::where('name', $data)->first();
            if ($check_tag) {
                $add = new Tagged();
                $add->Product_id = $Product->id;
                $add->tag_id = $check_tag->id;
                $add->save();
            } else {

                $add_tag = new Tag();
                $add_tag->name = $data;
                $add_tag->save();

                $add = new Tagged();
                $add->Product_id = $Product->id;
                $add->tag_id = $add_tag->id;
                $add->save();
            }
        }

        $images = array();
        if ($request->file1) {
            $file1 = $request->file1;
            $images[0] = $file1;
        }
        if ($request->file2) {
            $file2 = $request->file2;
            $images[1] = $file2;
        }
        if ($request->file3) {
            $file3 = $request->file3;
            $images[2] = $file3;
        }
        if ($request->file4) {
            $file4 = $request->file4;
            $images[3] = $file4;
        }
        if ($request->file5) {
            $file5 = $request->file5;
            $images[4] = $file5;
        }
        if ($request->file6) {
            $file6 = $request->file6;
            $images[5] = $file6;
        }
        if ($request->file7) {
            $file7 = $request->file7;
            $images[6] = $file7;
        }
        if ($request->file8) {
            $file8 = $request->file8;
            $images[7] = $file8;
        }
        if ($request->file9) {
            $images[8] = $request->file9;
        }
        if ($request->file10) {
            $images[9] = $request->file10;
        }
        if ($request->file11) {
            $images[10] = $request->file11;
        }

        foreach ($images as $key => $data) {
            if ($data) {
                $file_Name = time() . $key . '-Chat_File.' . $data->getClientOriginalExtension();
                $data->move(public_path('/images/uploads/'), $file_Name);
                $Image = '/images/uploads/' . $file_Name;
            }
            $ProductImage = new ProductImage();
            $ProductImage->path = $Image;
            $ProductImage->product_id = $Product->id;
            $ProductImage->save();
        }
        if ($product->type === "Variable Product") {
            $variations = json_decode($request->variations);
            $Attributes = Attribute::where('product_no', $product->product_no)->get();
            foreach ($Attributes as $key => $Attribute) {
                $Attribute->product_id = $Product->id;
                $Attribute->save();
            }
            foreach ($variations as $key => $data) {
                $discount = null;
                if (!empty($data->discount)) {
                    $discount = $data->discount;
                }
                $Variation = new Variation();
                $Variation->attribute1_id = $data->attribute1_id;
                $Variation->attribute2_id = $data->attribute2_id;
                $Variation->product_id = $Product->id;
                $Variation->stock = $data->stock;
                $Variation->number_of_stock = $data->number_of_stock;
                $Variation->threshold = $data->threshold;
                $Variation->weight = $data->weight;
                $Variation->height = $data->height;
                $Variation->Length = $data->Length;
                $Variation->width = $data->width;
                $Variation->discount = $discount;
                if ($data->file) {
                    $image = $data->file; // base64 encoded

                    $extension = explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];   // .jpg .png .pdf
                    $replace = substr($image, 0, strpos($image, ',') + 1);
                    $image = str_replace($replace, '', $image);
                    $image = str_replace(' ', '+', $image);
                    $imageName = time() . $key . '.' . $extension;
                    $path = public_path() . "/images/uploads/" . $imageName;
                    $image_decoded = base64_decode($image); // decoding File
                    file_put_contents($path, $image_decoded);
                    $Variation->image = '/images/uploads/' . $imageName; //Profile Image For Employee
                }
                $Variation->regular_price = $data->regular_price;
                $Variation->sale_price = $data->sale_price;
                $Variation->save();
            }
        }
        return response()->json('success');
    }

    public function update(Request $request)
    {
        $product = json_decode($request->product);

        $Product = Product::where('id', $product->id)->first();
        $Product->title = $product->title;
        $Product->product_no = $product->product_no;
        $Product->short_description = $product->short_description;
        $Product->long_description = $product->long_description;
        $Product->type = $product->type;
        $Product->brand_id = $product->brand_id;
        $Product->stock = $product->stock;
        $Product->number_of_stock = $product->number_of_stock;
        $Product->threshold = $product->threshold;
        $Product->weight = $product->weight;
        $Product->height = $product->height;
        $Product->Length = $product->Length;
        $Product->width = $product->width;
        $Product->video_link = $product->video_link;
        $Product->discount = $product->discount;
        $Product->regular_price = $product->regular_price;
        $Product->sale_price = $product->sale_price;
        $Product->save();


        $categories = $product->newCategories;
        ProductCategoried::where('product_id', $Product->id)->delete();
        foreach ($categories as $key => $data) {
            $add = new ProductCategoried();
            $add->Product_id = $Product->id;
            $add->category1_id = $data[0];
            $add->category2_id = $data[1];
            $add->category3_id = $data[2];
            $add->save();
        }


        $tags = $product->newTags;
        Tagged::where('product_id', $Product->id)->delete();
        foreach ($tags as $key => $data) {
            $check_tag = Tag::where('name', $data)->first();
            if ($check_tag) {
                $add = new Tagged();
                $add->Product_id = $Product->id;
                $add->tag_id = $check_tag->id;
                $add->save();
            } else {
                $add_tag = new Tag();
                $add_tag->name = $data;
                $add_tag->save();
                $add = new Tagged();
                $add->Product_id = $Product->id;
                $add->tag_id = $add_tag->id;
                $add->save();
            }
        }
        $images = array();
        if ($request->file1) {
            $file1 = $request->file1;
            $images[0] = $file1;
        }
        if ($request->file2) {
            $file2 = $request->file2;
            $images[1] = $file2;
        }
        if ($request->file3) {
            $file3 = $request->file3;
            $images[2] = $file3;
        }
        if ($request->file4) {
            $file4 = $request->file4;
            $images[3] = $file4;
        }
        if ($request->file5) {
            $file5 = $request->file5;
            $images[4] = $file5;
        }
        if ($request->file6) {
            $file6 = $request->file6;
            $images[5] = $file6;
        }
        if ($request->file7) {
            $file7 = $request->file7;
            $images[6] = $file7;
        }
        if ($request->file8) {
            $file8 = $request->file8;
            $images[7] = $file8;
        }
        if ($request->file9) {
            $images[8] = $request->file9;
        }
        if ($request->file10) {
            $images[9] = $request->file10;
        }
        if ($request->file11) {
            $images[10] = $request->file11;
        }
        if ($images[0] !== 'undefined') {
            ProductImage::where('product_id', $Product->id)->delete();
            foreach ($images as $key => $data) {
                if ($data) {
                    $file_Name = time() . $key . '-Product_Image.' . $data->getClientOriginalExtension();
                    $data->move(public_path('/images/uploads/'), $file_Name);
                    $Image = '/images/uploads/' . $file_Name;
                }
                $ProductImage = new ProductImage();
                $ProductImage->path = $Image;
                $ProductImage->product_id = $Product->id;
                $ProductImage->save();
            }
        }
        if ($product->type === "Variable Product") {
            Variation::where('product_id', $Product->id)->delete();
            $variations = json_decode($request->variations);
            $Attribute = Attribute::where('product_no', $product->product_no)->first();
            $Attribute->product_id = $Product->id;
            $Attribute->save();
            foreach ($variations as $key => $data) {
                $discount = null;
                if (!empty($data->discount)) {
                    $discount = $data->discount;
                }
                $Variation = new Variation();
                $Variation->attribute1_id = $data->attribute1_id;
                $Variation->attribute2_id = $data->attribute2_id;
                $Variation->product_id = $Product->id;
                $Variation->stock = $data->stock;
                $Variation->number_of_stock = $data->number_of_stock;
                $Variation->threshold = $data->threshold;
                $Variation->weight = $data->weight;
                $Variation->height = $data->height;
                $Variation->Length = $data->Length;
                $Variation->width = $data->width;
                $Variation->discount = $discount;
                if ($data->image) {
                    if (!preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', 'images/uploads/1596034943Avatar.jpg')) {
                        $Variation->image = $data->image;
                    } else {
                        $image = $data->image; // base64 encoded
                        $extension = explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];   // .jpg .png .pdf
                        $replace = substr($image, 0, strpos($image, ',') + 1);
                        $image = str_replace($replace, '', $image);
                        $image = str_replace(' ', '+', $image);
                        $imageName = time() . $key . '.' . $extension;
                        $path = public_path() . "/images/uploads/" . $imageName;
                        $image_decoded = base64_decode($image); // decoding File
                        file_put_contents($path, $image_decoded);
                        $Variation->image = '/images/uploads/' . $imageName; //Profile Image For Employee
                    }
                }
                $Variation->regular_price = $data->regular_price;
                $Variation->sale_price = $data->sale_price;
                $Variation->save();
            }
        }
        return response()->json('success');
    }

    public function categories()
    {
        $ProductCategory = Category1::with('children.children')->get();
        return response()->json($ProductCategory);
    }
    public function tags()
    {

        $Tag = Tag::get();
        return response()->json($Tag);
    }
}
