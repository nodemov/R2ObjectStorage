<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageUploadController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function imageUpload()
    {
        return view('imageUpload');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function imageUploadPost(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // $imageName = $request->image->getClientOriginalName();
        // $path = Storage::disk('s3')->put('/images', $request->image);
        $fileName  = $request->image->getClientOriginalName();

        Storage::disk('s3')->put('/' . $fileName, file_get_contents($request->image));

        $path = Storage::disk('s3Public')->url($fileName);

        // link will expire 5 hours from now.
        // $expires_at = now()->addHours(5);
        // $temporaryUrl = Storage::disk('s3Public')->temporaryUrl($path, $expires_at);


        return back()
            ->with('success', 'You have successfully upload image.')
            ->with('image', $path);
    }
}
