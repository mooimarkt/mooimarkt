<?php

namespace App\Http\Controllers\Admin;

use App\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LanguagesController extends Controller
{
    public function list()
    {
        $languages = Language::all();
        $Page = 'languages';

        return view('newthemplate.Admin.languages.list', compact('languages', 'Page'));
    }

    public function create()
    {
        $Page = 'language-create';
        return view('newthemplate.Admin.languages.create', compact('languages', 'Page'));
    }

    public function store(Request $request)
    {
        Language::create($request->except('_token'));

        return redirect()->route('languages.list');
    }

    public function edit(Language $language)
    {
        $Page = 'languages';
        return view('newthemplate.Admin.languages.edit', compact('language', 'Page'));
    }

    public function update(Request $request, Language $language)
    {
        $language->update($request->except('_token'));

        return redirect()->route('languages.list');
    }

    public function delete(Language $language)
    {
        if ($language->id != 1) {
            $language->delete();
        }

        return redirect()->back();
    }
}
