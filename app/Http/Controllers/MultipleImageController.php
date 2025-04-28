<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UploadImage; // Assuming you have an Image model
use Illuminate\Support\Facades\Storage;

class MultipleImageController extends Controller
{
    public function images()
    {
        // Fetch all images from the database
        $images = UploadImage::all();
        return view('multiple_image.imageupload',compact('images'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        $paths = [];
            
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $path = $image->storeAs($imageName); // custom filename
                $paths[] = $path;
            }
        }

        $upload = UploadImage::create([
            'name'     => $request->name,
            'quantity' => $request->quantity,
            'images'   => json_encode($paths), // Save array as JSON
        ]);
        // dd($upload);

        return redirect()->route('images')->withSuccess('Upload successful');

        // return response()->json([
        //     'success' => true,
        //     'message' => 'Images uploaded successfully',
        //     'data' => $upload,
            
        // ]);
    }

    public function edit($id)
    {
        $imageData = UploadImage::findOrFail($id);
        return view('multiple_image.imageedit', compact('imageData'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif',
        ]);
    
        $upload = UploadImage::findOrFail($id);
    
        // If new images are uploaded
        if ($request->hasFile('images')) {
    
            // First, delete old images
            $oldImages = json_decode($upload->images, true);
            if (is_array($oldImages)) {
                foreach ($oldImages as $oldImage) {
                    $oldImagePath = storage_path('app/public/uploads/' . $oldImage);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
            }
    
            // Now upload new images
            $paths = [];
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->storeAs($imageName); // store in correct folder
                $paths[] = $imageName;
            }
    
            // Update with new images
            $upload->images = json_encode($paths);
        }
    
        // Always update name and quantity
        $upload->name = $request->name;
        $upload->quantity = $request->quantity;
        $upload->save();
    
        return redirect()->route('images')->withSuccess('Update successful');
    }
    
}
