<?php

namespace App;

use App\GoogleSheet;
use Google_Client;
use Google_Service_Sheets;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Language extends Model
{
    protected $guarded = [];

    const defaultLang = 1;

    public static function getLanguages()
    {
        $slug = app()->getLocale();

        $language = Cache::get('language');
        if (isset($language) && isset($language->slug) && $language->slug !== $slug) {
            Cache::forget('language');
        }

        return Cache::remember('language', 60, function () use ($slug) {
            return static::where('slug', $slug)->first();
        });
    }

    public static function lang($value)
    {
        $languages = self::getLanguages();
        $word      = trim($value);
        $word      = preg_replace('|[\s]+|s', ' ', $word);

//        if (Cache::has('word_' . $word)) {
//            $resultWord = Cache::get('word_' . $word);
//        } else {
//            $resultWord = Word::where('name', $word)->first();
//            Cache::put('word_' . $word, $resultWord, 60);
//        }
        $resultWord = Word::where('name', $word)->first();

        if ($resultWord == null && !empty($word)) {
            Word::create([
                'name' => $word,
                'data' => [static::defaultLang => $word]
            ]);
        }

        $replace = isset($languages->id) && isset($resultWord->data[$languages->id]) ?
            $resultWord->data[$languages->id] :
            $word;

        return str_replace($word, $replace, $value);
    }
}
