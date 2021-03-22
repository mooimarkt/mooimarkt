<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\WordsImport;
use App\Exports\WordsExport;
use App\Language;
use App\Word;
use Yajra\DataTables\DataTables;

class WordsController extends Controller
{
    public static $defaultLang = Language::defaultLang;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $search = $request->search['value'];
            $words  = Word::query();

            if (!empty($search)) {
                $words->where('name', 'like', "%$search%");
            }

            return Datatables::of($words)
                ->addColumn('action', function ($word) {
                    return '<a href="' . route('words.edit', $word->id) . '" class="btn btn-info">Edit</a>
                            <a href="#" class="btn btn-danger delete-word">Remove</a>';
                })
                ->addColumn('word', function ($word) {
                    return '<input type="text" name="word" id="word" value="' . $word->data[1] . '">';
                })
                ->rawColumns(['word', 'action'])
                ->setRowAttr([
                    'data-id' => function ($word) {
                        return $word->id;
                    },
                ])
                ->make(true);
        }
        $Page = 'words';

        return view('newthemplate.Admin.words.list', compact('Page'));
    }

    public function edit(Request $request, Word $word)
    {
        $languages = Language::all();

        if ($request->all()) {
            foreach ($request->data as $id => $value) {
                $word->update([
                    'data->' . $id => $value
                ]);
            }
            return redirect()->back();
        }

        $Page = 'words-edit';
        return view('newthemplate.Admin.words.edit', compact('word', 'languages', 'Page'));
    }

    public function create(Request $request)
    {
        $word = Word::create([
            'name' => $request->word,
            'data' => [
                static::$defaultLang => $request->word
            ]
        ]);

        return response(['status' => 'success', 'message' => null, 'data' => $word], 200);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id'    => 'required',
            'name'  => 'required',
            'value' => 'required',
        ]);

        if ($request->name == 'word') {
            Word::find($request->id)->update([
                'data->' . static::$defaultLang => $request->value
            ]);
        }

        $response = $this->formatResponse('success', null);
        return response($response, 200);
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        Word::find($request->id)->delete();

        $response = $this->formatResponse('success', null);
        return response($response, 200);
    }

    public function import(Request $request)
    {
        $Page = 'words-import';

        if ($request->all()) {
            Excel::import(new WordsImport, $request->file);
            return redirect()->route('words.list', compact('Page'));
        }

        return view('newthemplate.Admin.words.import', compact('Page'));
    }

    public function export()
    {
        return Excel::download(new WordsExport, 'words.xlsx');
    }

    public function getDirContents($path)
    {
        $rii = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));

        $files = array();
        foreach ($rii as $file)
            if (!$file->isDir())
                $files[] = $file->getPathname();

        return $files;
    }

}

