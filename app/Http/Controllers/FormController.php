<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Datatables;
use App\SubCategory;
use App\FormField;
use App\FormFieldOption;
use App\SubCategoryField;
use App\TranslatorTranslations;

class FormController extends Controller
{

    public function getFormFieldPage(){

        $subCategories = SubCategory::all();
            return view('Admin/FormFieldPage', ["subCategories" => $subCategories]);

    }

    public function getFormFieldOptionPage(){

        $parentFields = DB::table('sub_categories')
                            ->join('subCategory_fields', 'subCategory_fields.subCategoryId', '=', 'sub_categories.id')
                            ->join('form_fields', 'form_fields.id', '=', 'subCategory_fields.formFieldId')
                            ->where('form_fields.fieldType', '!=', 'input')
                            ->where('subCategory_fields.isShare', 0)
                            ->whereNull('form_fields.deleted_at')
                            ->get();

        return view('Admin/FormFieldOptionPage', ["parentFields" => $parentFields]);
    }

    public function getShareFormFieldPage(){

        $field = DB::table('sub_categories')
                    ->join('subCategory_fields', 'subCategory_fields.subCategoryId', '=', 'sub_categories.id')
                    ->join('form_fields', 'form_fields.id', '=', 'subCategory_fields.formFieldId')
                    ->where('form_fields.fieldType', '!=', 'input')
                    ->whereNull('sub_categories.deleted_at')
                    ->whereNull('subCategory_fields.deleted_at')
                    ->whereNull('form_fields.deleted_at')
                    ->where('subCategory_fields.isShare', 0)
                    ->get();

        $subCategories = SubCategory::all();

        return view('Admin/ShareFormFieldPage', ['subCategories' => $subCategories, 'field' => $field]);
    }

    public function getShareFormFieldTable(){

        $shareFormFieldTable = DB::table('sub_categories')
                    ->join('subCategory_fields', 'subCategory_fields.subCategoryId', '=', 'sub_categories.id')
                    ->join('form_fields', 'form_fields.id', '=', 'subCategory_fields.formFieldId')
                    ->where('form_fields.fieldType', '!=', 'input')
                    ->whereNull('sub_categories.deleted_at')
                    ->whereNull('subCategory_fields.deleted_at')
                    ->whereNull('form_fields.deleted_at')
                    ->where('subCategory_fields.isShare', 1)
                    ->select('subCategory_fields.id', 'form_fields.fieldTitle', 'sub_categories.subCategoryName', 'subCategory_fields.formFieldId')
                    ->get();

        return Datatables::of($shareFormFieldTable)
                        ->addColumn('shareFromColumn', function($row){

                                $data = DB::table('sub_categories')
                                        ->join('subCategory_fields', 'subCategory_fields.subCategoryId', '=', 'sub_categories.id')
                                        ->whereNull('sub_categories.deleted_at')
                                        ->whereNull('subCategory_fields.deleted_at')
                                        ->where('subCategory_fields.formFieldId', $row->formFieldId)
                                        ->where('isShare', 0)
                                        ->get();

                                foreach($data as $datas){

                                    return $datas->subCategoryName;
                                }
                        })
                        ->make(true);
    }

    public function getFormFieldTable(){

        $formFieldTable = DB::table('sub_categories')
                                    ->join('subCategory_fields', 'subCategory_fields.subCategoryId', '=', 'sub_categories.id')
                                    ->join('form_fields', 'form_fields.id', '=', 'subCategory_fields.formFieldId')
                                    ->whereNull('sub_categories.deleted_at')
                                    ->whereNull('subCategory_fields.deleted_at')
                                    ->whereNull('form_fields.deleted_at')
                                    ->get();

        return Datatables::of($formFieldTable)
                        ->addColumn('fieldLevelColumn', function($row){

                                return $row->subCategoryName . " - Level " . $row->fieldLevel;
                        })
                        ->make(true);
    }

    public function getFormFieldOptionTable(){

        $formFieldOptionTable = DB::table('sub_categories')
                                    ->join('subCategory_fields', 'subCategory_fields.subCategoryId', '=', 'sub_categories.id')
                                    ->join('form_fields', 'form_fields.id', '=', 'subCategory_fields.formFieldId')
                                    ->join('form_field_options', 'form_field_options.formFieldId', '=', 'form_fields.id')
                                    ->whereNull('form_fields.deleted_at')
                                    ->whereNull('subCategory_fields.deleted_at')
                                    ->whereNull('form_field_options.deleted_at')
                                    ->get();

        return Datatables::of($formFieldOptionTable)
                        ->addColumn('fieldLevelColumn', function($row){

                                return $row->subCategoryName . " - Level " . $row->fieldLevel;
                        })
                        ->addColumn('parentName2', function($row){

                            $parentOptionRow = DB::table('form_field_options')
                                                ->select("value","parentName")
                                                ->where('id', '=', $row->parentFieldId)
                                                ->whereNull('deleted_at')
                                                ->first();
                                                //if(isset($parentOptionRow)){
/*return $parentOptionRow->parentName;
}else{
    return "asda";
}*/
                            if(isset($parentOptionRow)){
                                return $parentOptionRow->value . " (".$parentOptionRow->parentName." )";
                            }else{
                                return "No Parent";
                            }
                            //return $parentOptionRow;
                        })
                        ->addColumn('fieldValueColumn', function($row){

                                return $row->fieldTitle . "/" . $row->value;
                        })
                        ->make(true);
    }

    public function getParentField(Request $request){

        $fieldLevel = $request->input('fieldLevel');
        $currentSubCategoryId = $request->input('currentSubCategoryId');

        $parentFields = DB::table('sub_categories')
                            ->join('subCategory_fields', 'subCategory_fields.subCategoryId', '=', 'sub_categories.id')
                            ->join('form_fields', 'form_fields.id', '=', 'subCategory_fields.formFieldId')
                            ->whereNull('sub_categories.deleted_at')
                            ->whereNull('subCategory_fields.deleted_at')
                            ->whereNull('form_fields.deleted_at')
                            ->where('form_fields.fieldLevel', $fieldLevel)
                            ->where('form_fields.fieldType', '!=', 'input')
                            ->where('subCategoryId', $currentSubCategoryId)
                            ->get();

        return response()->json(['parentFields' => $parentFields, "success" => "success"]);
    }

    public function addFormField(Request $request){

        $subCategoryId = $request->input('subCategoryId');
        $fieldLevel = $request->input('fieldLevel');
        $parentFieldLevel = $request->input('parentFieldLevel');
        $fieldTitle = $request->input('fieldTitle');
        $fieldType = $request->input('fieldType');
        $fieldSort = $request->input('sort');
        $filterType = $request->input('dropDownFilterType');
        $displaySort = $request->input('displaySort');

        $parentName = DB::table('form_fields')
                        ->where('id', $parentFieldLevel)
                        ->value('fieldTitle');

        $formfield = new FormField;
        $formfield->fieldTitle = $fieldTitle;
        $formfield->fieldType = $fieldType;
        $formfield->filterType = $filterType;
        $formfield->fieldLevel = $fieldLevel;
        $formfield->parentFieldId = $parentFieldLevel;
        $formfield->parentName = $parentName;
        $formfield->sort = $fieldSort;
        $formfield->displaySort = $displaySort;
        $formfield->save();

        $subCategoryField = new SubCategoryFIeld;
        $subCategoryField->subCategoryId = $subCategoryId;
        $subCategoryField->formFieldId = $formfield->id;
        $subCategoryField->isShare = 0;
        $subCategoryField->save();

        $trans = new TranslatorTranslations;
        $trans->addTranslation('formfields', $fieldTitle);

        return response()->json(['success' => 'success']);
    }

    public function addFormFieldOption(Request $request){

        $formFieldId = $request->input('formFieldId');
        $value = $request->input('value');
        $parentId = $request->input('parentId');
        $sort = $request->input('sort');

        $parentName = DB::table('form_field_options')
                        ->where('id', $parentId)
                        ->value('value');

        $formFieldOption = new FormFieldOption;
        $formFieldOption->formFieldId = $formFieldId;
        $formFieldOption->parentFieldId = $parentId;
        $formFieldOption->value = $value;
        $formFieldOption->parentName = $parentName;
        $formFieldOption->sort = $sort;
        $formFieldOption->save();

        $trans = new TranslatorTranslations;
        $trans->addTranslation('options', $value);

        return response()->json(['success' => 'success']);
    }

    public function addShareFormField(Request $request){

        $formFieldId = $request->input('formFieldId');
        $subCategoryId = $request->input('subCategoryId');
        $fromSubCategoryId = $request->input('fromSubCategoryId');

        if($subCategoryId == 'all'){

            $subCategories = DB::table('sub_categories')
                            ->where('id', '!=', $fromSubCategoryId)
                            ->whereNull('deleted_at')
                            ->get();

            foreach($subCategories as $subCategory){

                $subCategoryField = new SubCategoryField;
                $subCategoryField->subCategoryId = $subCategory->id;
                $subCategoryField->formFieldId = $formFieldId;
                $subCategoryField->isShare = 1;
                $subCategoryField->save();
            }
        }
        else{
            $subCategoryField = new SubCategoryField;

            $subCategoryField->subCategoryId = $subCategoryId;
            $subCategoryField->formFieldId = $formFieldId;
            $subCategoryField->isShare = 1;

            $subCategoryField->save();
        }

        return response()->json(['success' => 'success']);

    }

    public function getFormOptionValue(Request $request){

        $currentFormId = $request->input('currentFormId');

        $formFieldOption = DB::table('form_fields')
                            ->join('form_field_options', 'form_field_options.formFieldId', '=', 'form_fields.id')
                            ->where('form_field_options.formFieldId', '=', $currentFormId)
                            ->whereNull('form_field_options.deleted_at')
                            ->get();

        return response()->json(['success' => 'success', 'formFieldOption' => $formFieldOption]);
    }

    public function updateFormField(Request $request){

        $formFieldId = $request->input('formFieldId');
        $formFieldTitle = $request->input('fieldTitle');
        $formSort = $request->input('sort');
        $filterType = $request->input('filterType');
        $displaySort = $request->input('displaySort');

        $formField = FormField::find($formFieldId);
        $formField->fieldTitle = $formFieldTitle;
        $formField->filterType = $filterType;
        $formField->sort = $formSort;
        $formField->displaySort = $displaySort;
        $formField->save();

        $result = array('success' => 1);

        return $result;
    }

    public function deleteFormField(Request $request){

        $formFieldId = $request->input('formFieldId');

        $formField = FormField::find($formFieldId);

        $parentFormField = FormField::where('parentFieldId', $formFieldId)->get();
        $countFormField = FormField::where('parentFieldId', $formFieldId)->count();

        if($countFormField > 0){

            foreach($parentFormField as $form){

                $form->delete();
            }
        }

        $formField->delete();


        $result = array('success' => 1);
        return $result;
    }

    public function updateFormFieldOption(Request $request){

        $formFieldOptionId = $request->input('formFieldOptionId');
        $value = $request->input('value');
        $sort = $request->input('sort');

        $formFieldOption = FormFieldOption::find($formFieldOptionId);
        $formFieldOption->value = $value;
        $formFieldOption->sort = $sort;
        $formFieldOption->save();

        $result = array('success' => 1);
        return $result;
    }

    public function deleteFormFieldOption(Request $request){

        $formFieldOptionId = $request->input('formFieldOptionId');

        $formFieldOption = FormFieldOption::find($formFieldOptionId);

        $formFieldOption->delete();

        $result = array('success' => 1);
        return $result;
    }

    public function deleteShareFormField(Request $request){

        $subCategoryFieldId = $request->input('subCategoryFieldId');

        $subCategoryField = SubCategoryField::find($subCategoryFieldId);
        $subCategoryField->delete();

        $result = array('success' => 1);
        return $result;
    }

    public function toShareGetFormField(Request $request){

        $subCategoryId = $request->input('toSubCategoryId');

        $field = DB::table('subCategory_fields')
                ->join('form_fields', 'form_fields.id', '=', 'subCategory_fields.formFieldId')
                ->whereNull('subCategory_fields.deleted_at')
                ->whereNull('form_fields.deleted_at')
                ->where('subCategory_fields.subCategoryId', $subCategoryId)
                ->get();

        return response()->json(['field' => $field, "success" => "success"]);

    }

    //User


    public function TestForAddParentName(Request $request){

        $tempo = DB::table('form_field_options')
                ->whereNull('form_field_options.deleted_at')
                ->get();

        foreach($tempo as $the){

            $saveParentName = FormFieldOption::find($the->id);

            if($the->parentFieldId == 0){

                $saveParentName->parentName = "No Parent";
            }
            else{

                $name = DB::table('form_field_options')
                        ->where('id', $the->parentFieldId)
                        ->value('value');

                $saveParentName->parentName = $name;
            }

            $saveParentName->save();
        }

        return "success";

    }

    public function TestForAddParentName2(Request $request){

        $tempo = DB::table('form_fields')
                ->whereNull('form_fields.deleted_at')
                ->get();

        foreach($tempo as $the){

            $saveParentName = FormField::find($the->id);

            if($the->parentFieldId == 0){

                $saveParentName->parentName = "No Parent";
            }
            else{

                $name = DB::table('form_fields')
                        ->where('id', $the->parentFieldId)
                        ->value('fieldTitle');

                $saveParentName->parentName = $name;
            }

            $saveParentName->save();
        }

        return "success";
    }
}
