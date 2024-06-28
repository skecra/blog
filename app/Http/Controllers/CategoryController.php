<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return view('back.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('back.categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Category $category)
    {
        if($request->has('image')){
           $image =  $this->uploadImage($request);
        }
        $category->title = $request->title;
        $category->image = $image;

        $category->save();
        // Category::create($request->post());
        return redirect()->route('categories.index')->with('message', 'Category created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('back.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        if($request->has('image')){
            $oldImage = $category->image;
            $this->uploadImage($request);
            if(file_exists(public_path('images/'.$oldImage))){
                unlink(public_path('images/'.$oldImage));
            }
            $category->image = $request->post()['image'];
        }
    
        $category->title = $request->title;

        // $category->update($request->post());
        $category->save();
        return back()->with(['ok' => 'The category has been updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category, Request $request)
    {
        $category->delete();
        return back();
    }

    public function uploadImage($request)
{
    // Check if the request has a file and if it's valid
    if ($request->hasFile('image') && $request->file('image')->isValid()) {
        $image = $request->file('image');

        // Generate a unique name for the image
        $imageName = time() . '_' . $image->getClientOriginalName();

        // Move the image to the public/images directory
        $destinationPath = public_path('images');
        
        // Ensure the directory exists and is writable
        if (!is_dir($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }
        
        // Move the image to the destination path
        if ($image->move($destinationPath, $imageName)) {
            // Return the new image name
            return $imageName;
        } else {
            // Handle the error
            throw new \Exception('Failed to move the uploaded file.');
        }
    } else {
        // Handle the error
        throw new \Exception('No valid image file found in the request.');
    }
}

}
