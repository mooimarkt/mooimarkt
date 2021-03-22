<?php

namespace App\Http\Controllers\Admin;

use App\HowWorksCategory;
use App\HowWorksItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class HowWorksController extends Controller
{
    public function categoriesList()
    {
        $Page = 'howWorksCategories';
        $howWorksCategories = HowWorksCategory::all();

        return view('newthemplate.Admin.howItWorks.categoriesList', compact('Page', 'howWorksCategories'));
    }

    public function categoryEdit($id)
    {
        $category = HowWorksCategory::find($id);
        $Page = 'edit-howWorksCategory';

        return view('newthemplate.Admin.howItWorks.add-category', compact('Page', 'category'));
    }

    public function categoryUpdate(Request $request, $id)
    {
        $category = HowWorksCategory::find($id);
        $category->title = $request->title;
        $category->save();

        $request->session()->flash('status', 'How It Works Category updated!');

        return redirect()->route('howWorks.categories.list');
    }

    public function categoryCreate()
    {
        $Page = 'add-howWorksCategory';

        return view('newthemplate.Admin.howItWorks.add-category', compact('Page'));
    }

    public function categoryStore(Request $request)
    {

        $category = new HowWorksCategory;
        $category->title = $request->title;
        $category->save();

        $request->session()->flash('status', ' how it works Category added!');

        return redirect()->route('howWorks.categories.list');
    }

    public function categoryDestroy($id)
    {
        $category = HowWorksCategory::find($id);
        $category->items()->delete();
        $category->delete();

        return response()->json(['status' => 'success', 'success' => 'Sucessfully delete How It Works item ']);
    }

    public function itemsList($categoryId)
    {
        $Page = 'howWorksItems';
        $category =  HowWorksCategory::find($categoryId);
        $items = $category->items ?? [];
        return view('newthemplate.Admin.howItWorks.itemsList', compact('Page', 'items'));
    }

    public function itemCreate()
    {
        $Page = 'add-howWorksItem';

        $categories = HowWorksCategory::pluck('title', 'id')->all();

        return view('newthemplate.Admin.howItWorks.add-item', compact('Page', 'categories'));
    }

    public function itemStore(Request $request)
    {
        if ($request->file('image') !== null) {
            $filename = md5( substr( str_replace( ' ', '', microtime() . microtime() ), 0, 40 ) . time() ) . '.' . $request->file('image')->getClientOriginalExtension() ;
            $path = $request->file('image')->storeAs(
                'howWorks', $filename, 'public'
            );
        }
        $request->merge(['image' => '/storage/'.$path]);

        $item= new HowWorksItem;
        $item->how_works_category_id = $request->how_works_category_id;
        $item->title = $request->title;
        $item->description = $request->description;
        $item->image = '/storage/'.$path;
        $item->save();

        $request->session()->flash('status', ' How It Works Category added!');
        return redirect()->route('howWorks.items.list', $request->how_works_category_id);
    }

    public function itemEdit($id)
    {
        $item = HowWorksItem::find($id);
        $categories = HowWorksCategory::pluck('title', 'id')->all();
        $Page = 'edit-howWorksItem';

        return view('newthemplate.Admin.howItWorks.add-item', compact('Page', 'categories', 'item'));
    }

    public function itemUpdate(Request $request, $id)
    {
        $item = HowWorksItem::find($id);

        $item->how_works_category_id = $request->how_works_category_id;

        $path = $item->image;

        if ($request->file('image') !== null) {
            $filename = md5( substr( str_replace( ' ', '', microtime() . microtime() ), 0, 40 ) . time() ) . '.' . $request->file('image')->getClientOriginalExtension() ;
            $path = $request->file('image')->storeAs(
                'howWorks', $filename, 'public'
            );
            $path = '/storage/'.$path;
        }
        $request->merge(['image' => $path]);

        $item->title = $request->title;
        $item->description = $request->description;
        $item->image = $path;
        $item->save();
        $request->session()->flash('status', 'How It Works Category added!');

        return redirect()->route('howWorks.items.list', $request->how_works_category_id);
    }

    public function itemDestroy($id)
    {
        $item = HowWorksItem::find($id);
        $item->delete();

        return response()->json(['status' => 'success', 'success' => 'Sucessfully delete How It Works item ']);
    }
}
