<?php

namespace App\Imports;

use App\Word;
use App\Language;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class WordsImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return Word|null
     */
    public function model(array $row)
    {
        $data      = collect($row);
        $languages = Language::all();

        $lang = $languages->where('slug', 'en')->first();

        if ($lang != null && isset($data['en']) && !empty($data['en']) && !is_numeric($data['en'])) {
            $word = Word::where('data->' . $lang->id, $data['en'])->first();
            if ($word === null) {
                $word = Word::create([
                    'name' => $data['en'],
                    'data' => [
                        $lang->id => $data['en']
                    ]
                ]);
            }

            $data->forget('en');

            $data->each(function ($item, $key) use ($languages, $word, $data) {
                $lang = $languages->where('slug', $key)->first();
                if ($lang !== null) {
                    $word->update(['data->' . $lang->id => $item]);
                }
            });

            return $word;
        }

        return null;
    }
}