<?php

namespace App\Exports;

use App\Word;
use App\Language;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class WordsExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    public function collection()
    {
        $words = Word::all();
        $words = $words->map(function ($item) {
            return array_sort($item->data, function ($value, $key) use ($item) {
                return $key;
            });
        });

        return $words;
    }

    public function headings(): array
    {
        $data = $this->collection()->map(function ($item) {
            return array_keys($item);
        })->collapse()->unique()->sort()->toArray();

        $language = Language::all()->pluck('id')->toArray();
        foreach ($language as $val) {
            if (!in_array($val, $data)) {
                $data[] = $val;
            }
        }

        $data = collect($data);
        $data = $data->map(function ($item) {
            $language = Language::find($item);
            if ($language !== null) {
                return Language::find($item)->slug;
            } else {
                return '';
            }
        })->toArray();

        return $data;
    }
}
