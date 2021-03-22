<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class NewFilterController extends Controller {

    public function getFilters(Request $request) {
        $filters = DB::table('new_filter')->where('category_id', $request->input('category_id'))->where('subcategory_id', $request->input('subcategory_id'))->whereNull('deleted_at')->get();

        if (count($filters)) {
            $inputs = [];

            foreach ($filters as $key => $filter) {
                //var_dump($filter);
                $class = '';

                switch ($filter->place_type) {
                    case "Input":
                            $id = 'filter_'.$key;

                            $inputs[] = '
                                <div class="input-group input-group-4 filter_ajax" style="padding: 0 20px; width: 25%;">
                                    <div class="input-group">
                                       <label for="'.$id.'">'.\App\Language::GetTextSearch($filter->filter_name).'</label>
                                       <input type="text" data-filter-name="'.$filter->filter_name.'" name="filter['.$filter->id.']" id="'.$id.'" value="" class="user-input" placeholder="">
                                    </div>
                                </div>
                            ';
                        break;
                    case "Autofill":
                            $id = 'filter_'.$key;

                            $inputs[] = '
                                <div class="input-group input-group-4 filter_ajax autofill" style="padding: 0 20px; width: 25%;">
                                    <div class="input-group">
                                       <label for="'.$id.'">'.\App\Language::GetTextSearch($filter->filter_name).'</label>
                                       <input type="text" data-filter-name="'.$filter->filter_name.'" name="filter['.$filter->id.']" id="'.$id.'" value="" class="user-input" placeholder="">
                                    </div>
                                </div>
                            ';
                        break;
                    case "Round Radio":
                        if (($filter->category_id == 36 or $filter->category_id == 37 or $filter->category_id == 41) and ($filter->filter_name == 'Make' or $filter->filter_name == 'Model')) {
                            $id = ($filter->filter_name == 'Make') ? 'FilterBrand' : 'FilterModel';
                            $attr = ($filter->filter_name == 'Make') ? '' : ' disabled';
                            $class = ($filter->filter_name == 'Make') ? 'add_brand' : 'add_model';

                            if ($filter->category_id == 41)
                                $id .= '_41';

                            $inputs[] = '
                                <div class="input-group input-group-4 filter_ajax" style="padding: 0 20px; width: 25%;">
                                    <div class="input-group">
                                       <label for="'.$id.'">'.\App\Language::GetTextSearch($filter->filter_name).'</label>
                                       <select id="'.$id.'" data-filter-name="'.$filter->filter_name.'" name="filter['.$filter->id.']" class="'.$class.'"'.$attr.' style="width: 100%;">
                                           <option value="">'.\App\Language::GetText(304).'</option>
                                       </select>
                                    </div>
                                </div>
                            ';
                        } elseif (($filter->category_id == 36 or $filter->category_id == 37) and ($filter->filter_name == 'Frame Make' or $filter->filter_name == 'Engine Make')) {
                            $id = ($filter->filter_name == 'Frame Make') ? 'FilterBrand' : 'FilterModel';
                            $attr = ($filter->filter_name == 'Frame Make') ? '' : ' disabled';
                            $class = ($filter->filter_name == 'Frame Make') ? 'add_brand' : 'add_model';

                            $inputs[] = '
                                <div class="input-group input-group-4 filter_ajax" style="padding: 0 20px; width: 25%;">
                                    <div class="input-group">
                                       <label for="'.$id.'">'.\App\Language::GetTextSearch($filter->filter_name).'</label>
                                       <select id="'.$id.'" data-filter-name="'.$filter->filter_name.'" name="filter['.$filter->id.']" class="'.$class.'"'.$attr.' style="width: 100%;">
                                           <option value="">'.\App\Language::GetText(304).'</option>
                                       </select>
                                    </div>
                                </div>
                            ';
                        } elseif (($filter->category_id == 39) and ($filter->filter_name == 'Brand' or $filter->filter_name == 'Model')) {
                            $id = ($filter->filter_name == 'Brand') ? 'FilterBrand_39' : 'FilterModel_39';
                            $attr = ($filter->filter_name == 'Brand') ? ' ' : ' disabled';
                            if ($filter->filter_name == 'Brand' and $filter->subcategory_id == 125)
                                $attr = ' disabled';

                            $class = ($filter->filter_name == 'Brand') ? 'add_brand' : 'add_model';

                            if ($filter->filter_name == 'Brand' and ($request->input('subcategory_id') == 133 or $request->input('subcategory_id') == 127 or $request->input('subcategory_id') == 128 or $request->input('subcategory_id') == 130 or $request->input('subcategory_id') == 126 or $request->input('subcategory_id') == 134) )
                                $attr = '';

                            $inputs[] = '
                                <div class="input-group input-group-4 filter_ajax" style="padding: 0 20px; width: 25%;">
                                    <div class="input-group">
                                       <label for="'.$id.'">'.\App\Language::GetTextSearch($filter->filter_name).'</label>
                                       <select id="'.$id.'" data-filter-name="'.$filter->filter_name.'" name="filter['.$filter->id.']" class="'.$class.'"'.$attr.' style="width: 100%;">
                                           <option value="">'.\App\Language::GetText(304).'</option>
                                       </select>
                                    </div>
                                </div>
                            ';
                        } elseif ($filter->category_id == 38 or $filter->category_id == 39 or $filter->category_id == 40 or $filter->category_id == 41 or $filter->category_id == 42) {
                            $id = 'filter_'.$key;

                            if ($filter->category_id == 38 and $filter->filter_name == 'Brand')
                                $id = 'BrandOther';

                            if ($filter->category_id == 40 and $filter->filter_name == 'Brand')
                                $id = 'BrandOther';

                            if ($filter->category_id == 41 and $filter->filter_name == 'Brand')
                                $id = 'BrandOther';

                            if ($filter->category_id == 39 and $filter->filter_name == 'Group')
                                $id = 'Group';

                            $input = '
                                <div class="input-group input-group-4 filter_ajax" style="padding: 0 20px; width: 25%;">
                                    <div class="input-group">
                                       <label for="'.$id.'">'.\App\Language::GetTextSearch($filter->filter_name).'</label>
                                       <select id="'.$id.'" data-filter-name="'.$filter->filter_name.'" name="filter['.$filter->id.']" class="user-input" style="width: 100%;">
                                           <option value="">'.\App\Language::GetText(304).'</option>';

                            $values = json_decode($filter->values, true);
                            if (is_array($values))
                                foreach ($values as $value)
                                    $input .= '<option value="'.$value.'">'.\App\Language::GetTextSearch($value).'</option>';

                            $input .= '
                                       </select>
                                    </div>
                                </div>
                            ';

                            $inputs[] = $input;
                        }

                        break;
                    case "Square Radio":
                        if ($filter->category_id == 39 or $filter->category_id == 40) {
                            $id = 'filter_'.$key;

                            $input = '
                                <div class="input-group input-group-4 filter_ajax" style="padding: 0 20px; width: 25%;">
                                    <div class="input-group">
                                       <label for="'.$id.'">'.\App\Language::GetTextSearch($filter->filter_name).'</label>
                                       <select id="'.$id.'" data-filter-name="'.$filter->filter_name.'" name="filter['.$filter->id.'][]" class="user-input" multiple style="width: 100%;">
                                           <option value="">'.\App\Language::GetText(304).'</option>';

                            $values = json_decode($filter->values, true);
                            if (is_array($values))
                                foreach ($values as $value)
                                    $input .= '<option value="'.$value.'">'.\App\Language::GetTextSearch($value).'</option>';

                            $input .= '
                                       </select>
                                    </div>
                                </div>
                            ';

                            $inputs[] = $input;
                        }

                        break;
                    default:
                        break;
                }

            }

            //var_dump($inputs);
            return response()->json([
                'status' => 'success',
                'inputs' => $inputs
            ]);
        } else
            return response()->json([
            'status' => 'error',
            'message' => 'Filters not found'
            ]);
    }

}