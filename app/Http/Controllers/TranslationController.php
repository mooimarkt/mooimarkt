<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Waavi\Translation\Repositories\LanguageRepository;
use Waavi\Translation\Repositories\TranslationRepository;
use Waavi\Translation\Facades\TranslationCache;
use Illuminate\Support\Facades\DB;
use App\TranslatorTranslations;
use Datatables;


class TranslationController extends Controller
{
    public function test(LanguageRepository $repo, TranslationRepository $lan){

        $language = $repo->find(1);
        
        $languageA = $lan->find(1);

        echo $languageA;

    }
	
	public function flush(TranslationCache $trans){
		
		$trans::flushAll();
	}

    public function getTranslationPage(){

        $translationLanguage = DB::table('translator_languages')
                                ->get();

        $translatorTranslation = DB::table('translator_translations')
                                ->get();

        $groupList = DB::table('translator_translations')
                                ->select('group')
                                ->distinct()
                                ->get();

        return view('Admin/TranslationPage', ['translationLanguage' => $translationLanguage, 'translatorTranslation' => $translatorTranslation, 'groupList' => $groupList]);
    }

    public function getTranslationTable(Request $request){

        $locale = $request->input('locale');
        $group = $request->input('group');

        $translationTable = DB::table('translator_languages')
                                ->join('translator_translations', 'translator_translations.locale', '=', 'translator_languages.locale')
                                ->where('translator_translations.locale', $locale)
                                ->where('translator_translations.group', $group)
                                ->get();

        return Datatables::of($translationTable)
                        ->addColumn('englishText', function($row){

                            $text = DB::table('translator_translations')
                                        ->where('translator_translations.item', $row->item)
                                        ->get();

                            foreach($text as $texts){

                                return $texts->text;
                            }
                        })
                        ->make(true);
    }

    public function updateTranslation(Request $request, TranslationCache $trans){

        $translationId = $request->input('translationId');
        $text = $request->input('translationText');

        $translatorTranslations = TranslatorTranslations::find($translationId);

        $translatorTranslations->text = $text;
        $translatorTranslations->save();

        $trans::flushAll();

        $result = array('success' => 1);

        return $result;

    }

    public function addForChinese(){

        $data = DB::table('translator_translations')
                ->where('translator_translations.locale', 'en')
                ->get();

        foreach($data as $datas){

            $translatorTranslations = new TranslatorTranslations;

            $translatorTranslations->locale = "de";
            $translatorTranslations->namespace = "*";
            $translatorTranslations->group = $datas->group;
            $translatorTranslations->item = $datas->item;
            $translatorTranslations->text = "";
            $translatorTranslations->unstable = 0;
            $translatorTranslations->locked = 0;
            $translatorTranslations->save();

        }

        echo "success";
    }

    public function changeLocale(Request $request){

        $request->session()->put('locale', $request->input('locale'));

        return response()->json(['success' => 'success']);
    }
}
