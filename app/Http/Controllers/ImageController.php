<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    /**
     * Display a listing of the images.
     */
    public function index()
    {
        return response()->json(Image::all());
    }

    /**
     * Store a newly created image in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240',
            'description' => 'nullable|string',
        ]);

        $imagePath = $request->file('image')->store('images', 'public');

        $image = Image::create([
            'filename' => $imagePath,
            'description' => $request->description,
            'user_id' => auth()->id(),
        ]);

        return response()->json($image, 201);
    }

    /**
     * Display the specified image.
     */
    public function show(Image $image)
{
    if (auth()->check()) {
        return response()->json($image);
    }

    return response()->json(['message' => 'Unauthorized'], 403);
}



    /**
     * Update the specified image in storage.
     */
    public function update(Request $request, Image $image)
    {
        if (auth()->id() !== $image->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'description' => 'nullable|string',
        ]);

        $image->update([
            'description' => $request->description,
        ]);

        return response()->json($image);
    }

    /**
     * Remove the specified image from storage.
     */
    public function destroy(Image $image)
    {
        if (auth()->id() !== $image->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        Storage::disk('public')->delete($image->filename);
        $image->delete();

        return response()->json(['message' => 'Image deleted successfully']);
    }
}