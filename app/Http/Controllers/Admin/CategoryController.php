<?php

namespace App\Http\Controllers\Admin;

use Image;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::latest()->paginate(10);
        $Page = 'category';
        return view('newthemplate.Admin.categories', compact(['categories', 'Page']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $Page = 'category';
        return view('newthemplate.Admin.add-category', compact(['Page']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Store image
        if ($request->file('image') !== null) {
            $filename = md5( substr( str_replace( ' ', '', microtime() . microtime() ), 0, 40 ) . time() ) . '.' . $request->file('image')->getClientOriginalExtension() ;
            $path = $request->file('image')->storeAs(
                'category', $filename, 'public'
            );
        }
        $request->merge(['categoryImage' => '/storage/'.$path]);

        // Create category
        Category::create([
            'categoryName' => $request->categoryName,
            'categoryStatus' => $request->categoryStatus,
            'categoryImage' => $request->categoryImage,
        ]);
        $request->session()->flash('status', 'Category added!');
        return redirect()->route('category.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $Page = 'category';
        return view('newthemplate.Admin.add-category', compact(['Page', 'category']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $path = $category->categoryImage;
        // Store image
        if ($request->file('image') !== null) {
            $filename = md5( substr( str_replace( ' ', '', microtime() . microtime() ), 0, 40 ) . time() ) . '.' . $request->file('image')->getClientOriginalExtension() ;
            $path = $request->file('image')->storeAs(
                'category', $filename, 'public'
            );
            $path = '/storage/'.$path;
        }
        $request->merge(['categoryImage' => $path]);

        // Create category
        $category->update([
            'categoryName' => $request->categoryName,
            'categoryStatus' => $request->categoryStatus,
            'categoryImage' => $request->categoryImage,
        ]);
        $request->session()->flash('status', 'Category updated!');
        return redirect()->route('category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if ($category->delete()) {
            return response()->json(['status' => 'success', 'success' => 'Sucessfully delete category and category subcategories']);
        } else {
            return response()->json(['error' => 'No access'], 403);
        }
    }
}
