<?php

namespace App\Http\Controllers;

use App\Category;
use App\Pricing;
use App\SubCategory;
use Illuminate\Http\Request;

class PricingController extends Controller {
	public function getPricingPage() {

		//$temp = array("listed" => 0,"auto-bump"=>array(7,14),"sportlight" =>10);
		//dd(json_encode($temp,0));
		$category = Category::all();

		//$pricing = Pricing::where('subCategoryId', "40")->get();


		return view( 'newthemplate/pricing', [ 'category' => $category ] );
		return view( 'user/pricing', [ 'category' => $category ] );
	}

	public function PricingGetSubCategory( Request $request ) {

		$categoryId = $request->input( 'categoryId' );

		$subCategory = SubCategory::where( 'categoryId', $categoryId )->get();
        $subCategoryArray = [];

        foreach ($subCategory as $key => $cat) {
            $subCategoryArray[$key] = $cat;
            $subCategoryArray[$key]->subCategoryName = \App\Language::GetTextSearch($subCategoryArray[$key]->subCategoryName);
        }

		return response()->json( [ 'subCategory' => $subCategoryArray ] );

	}

	public function getPricingBySubCategory( Request $request ) {

		$ads_details   = [];
		$subCategoryId = $request->input( 'subCategoryId' );
		$offer_option  = $request->input( 'offer_option' );

		$query = Pricing::where( 'subCategoryId', $subCategoryId );
		if ( $offer_option ) {
			$query->whereIn( "offer_option", array( "all", $offer_option ) );
		}
		$pricing = $query->get();

		if ( ! $pricing->count() ) {
			$subCategoryId = "0"; // default
			$query         = Pricing::where( 'subCategoryId', $subCategoryId );
			if ( $offer_option ) {
				$query->whereIn( "offer_option", array( "all", $offer_option ) );
			}
			$pricing = $query->get();
		}
		$countPricing = Pricing::where( 'subCategoryId', $subCategoryId )->count();
		if ( $countPricing > 0 ) {

			$result = 'success';
		} else {

			$result = 'fail';

		}

		return response()->json( [ 'pricing' => $pricing, 'success' => $result, "pricing_details" => $pricing ] );
	}

	public function getPricingBySubCategory2( Request $request ) {

		$res = $request->validate( [
			'scid'  => 'required|integer',
			'offer' => 'required|string',
		] );

		$price = Pricing::where( [
			'subCategoryId'=> $res['scid'],
			'offer_option' => $res['offer']
		])->get();

		if(count($price) > 0){

			return response()->json(
				[
					'status'=>'success',
					'message'=>'Price found',
					'pricing'=>$price
				]
			);

		}

		return response()->json(
			[
				'status'=>'error',
				'message'=>'Price not found',
			]
		);
	}
}
