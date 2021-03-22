<?php

namespace App;

use App\Services\SortService;
use Illuminate\Database\Eloquent\Model;

class Filter extends Model
{
    public function parent()
    {
        return $this->belongsTo(Filter::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Filter::class, 'parent_id');
    }

    public function filterSize()
    {
        return $this->hasOne(FilterTypeSize::class);
    }

    public static function getChildrenFilters($id)
    {
        return Filter::find($id)->first()->children()->get();
    }

    public static function getName($id)
    {
        return Filter::find($id)->first()->name;
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    public static function addFilter($filter) {
        $newFilter = new Filter;
        $newFilter->name = $filter[1];
        $newFilter->parent_id = $filter[0];
        $newFilter->save();

        return $newFilter;
    }

    public static function getNested($subCategoryId)
    {
        $filters = [];
        $filtersSubCategory = Filter::where('sub_category_id', $subCategoryId)->get();
        foreach ($filtersSubCategory as $item) {
            if ($item->children !== null) {
                foreach ($item->children as $child) {
                    if ($child->children !== null) {
                        foreach ($child->children as $subChild) {
                            $filters[] = $subChild->toArray();
                        }
                    }
                    $filters[] = $child->toArray();
                }
            }
            $filters[] = $item->toArray();
        }

        $array = SortService::getNested($filters);

        return $array;
    }

    public static function saveOrder($categories)
    {
        dd('test');
        if (count($categories))
        {
            foreach($categories as $order => $category)
            {
                $data = [
                    'parent_id' => (int) $category['parent_id'],
                    'sort' => $order,
                    '_lft'=>$category['left'],
                    '_rgt'=>$category['right'],
                ];
                Filter::where('id', $category['id'])
                    -> update($data);
            }
        }
    }
}
