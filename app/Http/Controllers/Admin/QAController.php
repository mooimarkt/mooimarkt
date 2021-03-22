<?php

namespace App\Http\Controllers\Admin;

use App\QACategory;
use App\QAItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class QAController extends Controller
{
    public function categoriesList()
    {
        $Page = 'qaCategories';
        $QACategories = QACategory::all();

        return view('newthemplate.Admin.q_a_s.categoriesList', compact('Page', 'QACategories'));
    }

    public function categoryEdit($id)
    {
        $category = QACategory::find($id);
        $Page = 'edit-qaCategory';

        return view('newthemplate.Admin.q_a_s.add-category', compact('Page', 'category'));
    }

    public function categoryUpdate(Request $request, $id)
    {
        $category = QACategory::find($id);

        $path = $category->image;

        if ($request->file('image') !== null) {
            $filename = md5( substr( str_replace( ' ', '', microtime() . microtime() ), 0, 40 ) . time() ) . '.' . $request->file('image')->getClientOriginalExtension() ;
            $path = $request->file('image')->storeAs(
                'qa', $filename, 'public'
            );
            $path = '/storage/'.$path;
        }
        $request->merge(['image' => $path]);

        $category->title = $request->title;
        $category->description = $request->description;
        $category->image = $path;
        $category->save();

        $request->session()->flash('status', 'QA Category updated!');

        return redirect()->route('qa.categories.list');
    }

    public function categoryCreate()
    {
        $Page = 'add-qaCategory';

        return view('newthemplate.Admin.q_a_s.add-category', compact('Page'));
    }

    public function categoryStore(Request $request)
    {
        // Store image
        if ($request->file('image') !== null) {
            $filename = md5( substr( str_replace( ' ', '', microtime() . microtime() ), 0, 40 ) . time() ) . '.' . $request->file('image')->getClientOriginalExtension() ;
            $path = $request->file('image')->storeAs(
                'qa', $filename, 'public'
            );
        }
        $request->merge(['image' => '/storage/'.$path]);

        // Create category
        $category = new QACategory;
        $category->title = $request->title;
        $category->description = $request->description;
        $category->image = '/storage/'.$path;
        $category->save();

        $request->session()->flash('status', ' QA Category added!');
        return redirect()->route('qa.categories.list');
    }

    public function categoryDestroy($id)
    {
        $category = QACategory::find($id);
        $category->items()->delete();
        $category->delete();

        return response()->json(['status' => 'success', 'success' => 'Sucessfully delete QA item ']);
    }

    public function itemsList($categoryId)
    {
        $Page = 'qaItems';
        $category =  QACategory::find($categoryId);
        $items = $category->items ?? [];
        return view('newthemplate.Admin.q_a_s.itemsList', compact('Page', 'items'));
    }

    public function itemCreate()
    {
        $Page = 'add-qaItem';

        $categories = QACategory::pluck('title', 'id')->all();

        return view('newthemplate.Admin.q_a_s.add-item', compact('Page', 'categories'));
    }

    public function itemStore(Request $request)
    {
        // Create category
        $item= new QAItem;
        $item->q_a_category_id = $request->q_a_category_id;
        $item->question = $request->question;
        $item->answer = $request->answer;
        $item->save();

        $request->session()->flash('status', ' QA Category added!');
        return redirect()->route('qa.items.list', $request->q_a_category_id);
    }

    public function itemEdit($id)
    {
        $item = QAItem::find($id);
        $categories = QACategory::pluck('title', 'id')->all();
        $Page = 'edit-qaItem';

        return view('newthemplate.Admin.q_a_s.add-item', compact('Page', 'categories', 'item'));
    }

    public function itemUpdate(Request $request, $id)
    {
        $item = QAItem::find($id);

        $item->q_a_category_id = $request->q_a_category_id;
        $item->question = $request->question;
        $item->answer = $request->answer;
        $item->save();
        $request->session()->flash('status', ' QA Category added!');

        return redirect()->route('qa.items.list', $request->q_a_category_id);
    }

    public function itemDestroy($id)
    {
        $item = QAItem::find($id);
        $item->delete();

        return response()->json(['status' => 'success', 'success' => 'Sucessfully delete QA item ']);
    }
}
