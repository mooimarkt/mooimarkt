<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\SubCategory;
use App\Pricing;

class PackageController extends Controller
{
	public function getPackagePage(){

		$category = Category::all();

		$input_ary[] = array(
						"name" => "Basic Package",
						"type_name" => "basic"
					);
		$input_ary[] = array(
						"name" => "Auto-Bump Package",
						"type_name" => "auto-bump"
					);
		$input_ary[] = array(
						"name" => "Spolight Package",
						"type_name" => "spotlight"
					);
		$input_ary[] = array(
						"name" => "Auto-Bump add-ons (Basic)",
						"type_name" => "basic-bump-addOn"
					);
		$input_ary[] = array(
						"name" => "Auto-Bump add-ons (Auto Bump)",
						"type_name" => "ab-bump-addOn"
					);
		$input_ary[] = array(
						"name" => "Auto-Bump add-ons (Spotlight)",
						"type_name" => "spotlight-bump-addOn"
					);
		$input_ary[] = array(
						"name" => "Spotlight add-ons (Basic)",
						"type_name" => "basic-spotlight-addOn"
					);
		$input_ary[] = array(
						"name" => "Spotlight add-ons (Auto-bump)",
						"type_name" => "ab-spotlight-addOn"
					);
		$input_ary[] = array(
						"name" => "Spotlight add-ons (Spotlight)",
						"type_name" => "spotlight-spotlight-addOn"
					);

	    return view('Admin/PackageManagementPage', ["category" => $category, "option_ary" =>$input_ary]);
	}

	public function getPackageSubCategory(Request $request){

		$categoryId = $request->input('categoryId');

		$subCategory = SubCategory::where('categoryId', $categoryId)
                        ->orderBy('sort', 'desc')
                        ->orderBy('subCategoryName', 'asc')
                        ->whereNull('deleted_at')
                        ->get();


     return response()->json([ 'subCategory' => $subCategory ]);
	}

	public function getSubCategoryPackage(Request $request){
		$subCategoryId = $request->input('subCategoryId');
		$package = Pricing::where('subCategoryId', $subCategoryId)->get();

		return response()->json([ 'package' => $package ]);
	}
	public function save_package(Request $request){
		$subCategoryId = $request->input('dropDownSubCategory');

		$type_ary = array("basic","auto-bump","spotlight","basic-bump-addOn","ab-bump-addOn","spotlight-bump-addOn","basic-spotlight-addOn","ab-spotlight-addOn","spotlight-spotlight-addOn");

		foreach($type_ary as $package_type){
			if($request->input($package_type)=="on"){
				if($request->input($package_type."_price") != ""){
					//$data_ary = ["listed"=>$request->input($package_type.'_listed'),"auto-bump"=>$request->input($package_type.'_auto-bump'),"spotlight"=>$request->input($package_type.'_spotlight')];
					$data_ary = ["listed"=>$request->input($package_type.'_listed'),"auto-bump"=>$request->input($package_type.'_auto-bump'),"spotlight"=>$request->input($package_type.'_spotlight')];
					$check = ["price"=>$request->input($package_type."_price"),
								"subCategoryId" => $subCategoryId,"type" => $package_type];
					$insert = ["price"=>$request->input($package_type."_price"),
								"subCategoryId" => $subCategoryId,
								"data"=>json_encode($data_ary),
								"offer_option" => $request->input($package_type.'_offer_option')];

					$pricing = Pricing::updateOrCreate($check,$insert);
				}
			}else{
				$pricing = Pricing::WHERE("subCategoryId","=",$subCategoryId)->WHERE("type","=", $package_type);
				if($pricing){
					$pricing->delete();
				}
			}
		}
		return response()->json([ 'package' => "" ]);
	}
}
