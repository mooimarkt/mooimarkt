<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subcategories = SubCategory::latest()->paginate(10);
        $Page = 'subcategory';
        return view('newthemplate.Admin.subcategories', compact(['subcategories', 'Page']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $Page = 'category';
        $categories = Category::all();
        return view('newthemplate.Admin.add-subcategory', compact(['Page', 'categories']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        SubCategory::create($request->all());
        $request->session()->flash('status', 'SubCategory added!');
        return redirect()->route('subcategory.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(SubCategory $subcategory)
    {
        $categories = Category::all();
        $Page = 'subcategory';
        return view('newthemplate.Admin.add-subcategory', compact(['Page', 'categories', 'subcategory']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubCategory $subcategory)
    {
        $subcategory->update($request->all());
        $request->session()->flash('status', 'SubCategory updated!');
        return redirect()->route('subcategory.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubCategory $subcategory)
    {
        if ($subcategory->delete()) {
            return response()->json(['status' => 'success', 'success' => 'Sucessfully delete subcategory']);
        } else {
            return response()->json(['error' => 'No access'], 403);
        }
    }
}
