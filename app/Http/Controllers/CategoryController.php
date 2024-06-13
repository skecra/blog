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
    public function store(Request $request, Catgegory $category)
    {
        if($request->has('image')){
            $oldImage = $post->image;
            $this->uploadImage($request);
            if(file_exists(public_path('images/'.$oldImage))){
                unlink(public_path('images/'.$oldImage));
            }
            $category->image = $request->post()['image'];
        }
        $category->title = $request->title;

        $category->create();
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
            $oldImage = $post->image;
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
    public function destroy(Category $category)
    {
        $category->delete();
        return back();
    }

    public function uploadImage($request){
        $image = $request->file('image');
        $imageName = time().$image->getClientOriginalName();
        // add the new file
        $image->move(public_path('images'),$imageName);
        $request->merge(['image' => $imageName]);
        // dd($request);
    }
}
