<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Event;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::get();
        return response()->json($events);
    }
    public function store(Request $request)
    {
        $data = $request->data;
        $image = $data['image']; // base64 encoded
        $extension = explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];   // .jpg .png .pdf
        $replace = substr($image, 0, strpos($image, ',') + 1);
        $image = str_replace($replace, '', $image);
        $image = str_replace(' ', '+', $image);
        $imageName = time() . 'event.' . $extension;
        $path = public_path() . "/images/uploads/" . $imageName;
        $image_decoded = base64_decode($image); // decoding File
        file_put_contents($path, $image_decoded);
        $image_ = '/images/uploads/' . $imageName; //full path

        $event = new Event();
        $event->title = $data['title'];
        $event->image = $image_;
        if (!empty($data['link'])) {
            $event->link = $data['link'];
        }
        $event->save();
        return response()->json('success');
    }

    public function update(Request $request)
    {
        $data = $request->data;
        $event = Event::where('id', $data['id'])->get();
        $event->title = $data['title'];
        if ($data['image'] !== $event->image) {
            $image = $data['image']; // base64 encoded
            $extension = explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];   // .jpg .png .pdf
            $replace = substr($image, 0, strpos($image, ',') + 1);
            $image = str_replace($replace, '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = time() . 'event.' . $extension;
            $path = public_path() . "/images/uploads/" . $imageName;
            $image_decoded = base64_decode($image); // decoding File
            file_put_contents($path, $image_decoded);
            $event->image = '/images/uploads/' . $imageName; //full path
        }
        if (!empty($data['link'])) {
            $event->link = $data['link'];
        }
        $event->save();
        return response()->json('success');
    }

    public function destroy($id)
    {
        Event::where('id', $id)->delete();
        return response()->json('success');
    }
}
