<?php

namespace App\Http\Controllers\Admin;

use App\Filter;
use App\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FiltersController extends Controller
{
    public function allFilters($subCategoryId) {
        $Page = 'filters';
        $subCategory = SubCategory::find($subCategoryId);
        $category = $subCategory->category;

        return view('newthemplate.Admin.filters.index', compact('Page', 'subCategory', 'category'));
    }

    public function sortAjax(Request $request, $subCategoryId)
    {
        if ($request->isMethod('post') && $request->get('sortable'))
        {
            Filter::saveOrder($request->get('sortable'));
        }

        $filters = Filter::getNested($subCategoryId);

        return view('newthemplate.Admin.filters.sortAjax', ['items'=> $filters]);
    }

    public function create($subCategoryId)
    {
        $Page = 'filters-create';
        $subCategory = SubCategory::find($subCategoryId);
        $category = $subCategory->category;
        $templates = $this->templates();

        $filters = [];
        $filtersSubCategory = Filter::where('sub_category_id', $subCategoryId)->get();
        foreach ($filtersSubCategory as $item) {
            $filters[] = $item;
            if ($item->children !== null && $item->template == 'type') {
                foreach ($item->children as $child) {
                    $filters[] = $child;
                }
            }
        }

        return view('newthemplate.Admin.filters.create', compact('Page', 'subCategory', 'category', 'filters', 'templates'));
    }

    public function store(Request $request, $subCategoryId)
    {
        $filter = new Filter;
        if (stristr($request->parent_id, 'category')) {
            $filter->sub_category_id = $subCategoryId;
            $filter->template = $request->template;
        } else {
            $filter->parent_id = $request->parent_id;
            $filter->template = 'standard';
        }
        $filter->name = $request->name;
//        $filter->sort = $request->sort;
        $filter->save();

        return redirect()->route('admin.filters.show', ['subCategoryId' => $subCategoryId]);
    }

    public function edit($subCategoryId, $filterId)
    {
        $Page = 'filters-edit';
        $subCategory = SubCategory::find($subCategoryId);
        $category = $subCategory->category;
        $currentFilter = Filter::find($filterId);
        $templates = $this->templates();

        $filters = [];
        $filtersSubCategory = Filter::where('sub_category_id', $subCategoryId)->get();
        foreach ($filtersSubCategory as $item) {
            $filters[] = $item;
            if ($item->children !== null && $item->template == 'type') {
                foreach ($item->children as $child) {
                    $filters[] = $child;
                }
            }
        }

        return view('newthemplate.Admin.filters.edit', compact('Page', 'subCategory', 'category', 'filters', 'currentFilter', 'templates'));
    }

    public function update(Request $request, $subCategoryId, $filterId)
    {
        $filter = Filter::find($filterId);
        if ($filter !== null) {
            if (stristr($request->parent_id, 'category')) {
                $filter->sub_category_id = $subCategoryId;
                $filter->parent_id = null;
                $filter->template = $request->template;
            } else {
                $filter->sub_category_id = null;
                $filter->parent_id = $request->parent_id;
                $filter->template = 'standard';
            }
            $filter->name = $request->name;
//            $filter->sort = $request->sort;
            $filter->save();
        }

        return redirect()->route('admin.filters.show', ['subCategoryId' => $subCategoryId]);
    }

    public function delete($filterId)
    {
        $filter = Filter::find($filterId);
        if ($filter !== null) {
            $filter->delete();
        }

        $response = $this->formatResponse('success', null);
        return response($response, 200);
    }

    public function templates()
    {
        return [
            'type' => 'Type',
            'color' => 'Color',
            'brand' => 'Brand',
            'standard' => 'Standard',
            'material' => 'Material',
            'size' => 'Size'
        ];
    }
}
