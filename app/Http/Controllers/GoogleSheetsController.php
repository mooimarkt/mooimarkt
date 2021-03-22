<?php

namespace App\Http\Controllers;

use App\Category;
use App\GoogleSheets;
use App\Option;
use App\SubCategory;
use Illuminate\Http\Request;
use Google_Service_JobService_SearchJobsRequest;
use Google_Service_JobService_JobQuery;
use Google_Service_JobService_RequestMetadata;
use Illuminate\Support\Facades\DB;

class GoogleSheetsController extends Controller {

	public function Test( Request $request ) {

		$Google = new GoogleSheets();

		// dump( $Google->getSpreadSheet( "1qV3YQxaHVLNRsvi1vSltzHU4QrBOengxPMahmR2sovY" )->Color( "Main!A9:O9" ) );
		dump( $Google->getSpreadSheet( "1qV3YQxaHVLNRsvi1vSltzHU4QrBOengxPMahmR2sovY" )->Read( "Main" ) );
		/*dump( $Google->getSpreadSheet("1qV3YQxaHVLNRsvi1vSltzHU4QrBOengxPMahmR2sovY")->Write("Main!A9:O9",[
			[
				"1","2","3"
			]
		]) ); */

		dd($this->import());

	}

	public function import( ) {

		$Google = new GoogleSheets();

		if ( ! is_string( $Google ) ) {

         $list = $Google->getSpreadSheet( "1qV3YQxaHVLNRsvi1vSltzHU4QrBOengxPMahmR2sovY" )->Read( "01 Bike and Quad" );

         if ( is_array( $list ) && count( $list ) > 0 ) {

				if ( ! key_exists( 'error', $list ) ) {

					$lst = &$list;
               $categories = [];
               $next = false;
               $prefix = 0;
               $model_keys = [];

					foreach ( $lst as $key => &$row ) {

							if(count($row) == 0){
								continue;
							}
                     if($row[0] == "Make " or $row[0] == "Frame") {
                        $next = false;
                     }

                     if($row[0] == "Make ") {
                        $prefix++;
                        foreach ($row as $key2 => $cat) {
                           if (strlen($cat) > 0 and $key2 > 0) {
                              $model_keys[] = $key2;
                              $categories[$prefix."_".$key2] = [
                                 'name' => trim($cat),
                                 'type'=> '',
                                 'models' => []
                              ];
                           }
                        }
                     }


                     if ($next == true) {
                        foreach ($row as $key2 => $model) {
                           if (in_array($key2, $model_keys) and strlen($model) > 0 and strlen($row[0]) > 0) {
                              $categories[$prefix."_".$key2]['models'][] = $model;
                              $categories[$prefix."_".$key2]['type'] = $row[0];
                           }
                        }
                     }

                     if($row[0] == "Model") {
                        $next = true;
                     }

					}

               $Categories = [];

               foreach ($categories as $cat) {
                  if (!isset($Categories[$cat['name']]))
                     $Categories[$cat['name']] = [
                        'models' => []
                     ];

                  if (!isset($Categories[$cat['name']]['models'][$cat['type']]))
                     $Categories[$cat['name']]['models'][$cat['type']] = [];

                  foreach ($cat['models'] as $model)
                     $Categories[$cat['name']]['models'][$cat['type']][] = $model;
               }

               $brand_no_deleted = [];
               foreach ($Categories as $brand => $category) {
                  $brand_no_deleted[] = $brand;

                  $Cat = DB::table('filter')->where('brand', $brand)->first();

                  if ($Cat == NULL) {
                     $id = DB::table('filter')->insertGetId([
                        "brand" => $brand,
                        "models" => json_encode($category['models'])
                     ]);
                  } else {
		               DB::table('filter')->where('id', $Cat->id)->update([
                        "models" => json_encode($category['models'])
                     ]);
                  }

               }

               DB::table('filter')->whereNotIn('brand', $brand_no_deleted)->delete();
            } else {

					return redirect()->back()->withErrors( [ "Get Google Sheet Error" ] );

				}
         }

			$data = [
				"Categories"=>[
					'new'=>[],
					'updated'=>[],
					'deleted'=>0
				],
				"SubCategories"=>[
					'new'=>[],
					'updated'=>[],
					'deleted'=>0
				]
			];

			$list = $Google->getSpreadSheet( "1qV3YQxaHVLNRsvi1vSltzHU4QrBOengxPMahmR2sovY" )->Read( "Main" );

			if ( is_array( $list ) && count( $list ) > 0 ) {

				if ( ! key_exists( 'error', $list ) ) {

					$lst = &$list;

					$cats_ids = [];
					$subcats_ids = [];

					foreach ( $lst as &$row ) {

						if ( is_array( $row ) ) {

							if(count($row) == 0){
								continue;
							}

							if ( strpos(strtolower( $row[0] ),"section") === 0) {

								break;
							}

							if ( intval( $row[0] ) == 0 ) {
								continue;
							}

							$category = Category::where( 'shid', $row[0] )->first();

							if ( is_null( $category ) ) {

								$category = Category::where( 'categoryName', $row[1] )->withTrashed()->first();

								if ( is_null( $category ) ) {

									$category                 = new Category();
									$category->categoryStatus = 0;
									$category->categoryImage  = "/newthemplate/img/logo.svg";

									$data['Categories']['new'][] = $row[1];

								}else{

									$data['Categories']['updated'][] = $row[1];

									if(!is_null($category->deleted_at)){
										$category->restore();
									}

								}

							}else{

								$data['Categories']['updated'][] = $row[1];

							}
							$category->shid         = $row[0];
							$category->categoryName = $row[1];
							$sub_cats = $category->subCategories()->withTrashed()->get();
							$cats_ids[] = $category->id;
							$category->save();

							$rw = array_slice( $row, 3 );

							foreach ( $rw as $i => $col ) {

								if(strlen($col) == 0){
									continue;
								}

								if ( count( $sub_cats ) > 0 ) {

									$aded = false;

									foreach ($sub_cats as &$sub_cat){

										if($sub_cat->shrid == $i+1 && is_null($sub_cat->deleted_at)){

											$sub_cat->subCategoryName = $col;

											$aded = true;

											$sub_cat->save();

											$subcats_ids[] = $sub_cat->id;

											break;

										}elseif (strtolower($sub_cat->subCategoryName) == strtolower($col)){

											$sub_cat->shrid = $i+1;
											$sub_cat->subCategoryName = $col;

											$aded = true;

											if(!is_null($sub_cat->deleted_at)){

												$category->subCategories()->withTrashed()->where('id',$sub_cat->id)->restore();

											}

											$sub_cat->save();

											$subcats_ids[] = $sub_cat->id;

											break;

										}


									}

									if(!$aded){

										$data['SubCategories']['new'][] = $col;

										$new_subcat = SubCategory::create( [
											"categoryId"      => $category->id,
											"subCategoryName" => $col,
											"sort"            => 1,
											"shrid"           => $i+1,
										]);

										$subcats_ids[] = $new_subcat->id;

									}else{

										$data['SubCategories']['updated'][] = $col;
									}

								} else {

									$data['SubCategories']['new'][] = $col;

									$new_subcat = SubCategory::create( [
										"categoryId"      => $category->id,
										"subCategoryName" => $col,
										"sort"            => 1,
										"shrid"           => $i+1,
									]);

									$subcats_ids[] = $new_subcat->id;

								}

							}

							unset( $rw );
							unset( $sub_cats );
							unset( $category );

						}

					}

					unset( $lst );
					unset( $list );

					$data['Categories']['deleted'] = Category::whereNotIn('id',$cats_ids)->delete();
					$data['SubCategories']['deleted'] = SubCategory::whereNotIn('id',$subcats_ids)->delete();

				} else {

					return redirect()->back()->withErrors( [ "Get Google Sheet Error" ] );

				}

			}

		} else {

			return redirect()->back()->withErrors( [ $Google ] );

		}

		return redirect()->back()->with('success', $data);

	}

	public function export()
	{
		$Google = new GoogleSheets();
		$spreadSheetId = '1qV3YQxaHVLNRsvi1vSltzHU4QrBOengxPMahmR2sovY';

		if ( ! is_string( $Google ) ) {

			$list = $Google->getSpreadSheet( $spreadSheetId )->Read( "Main" );

			// Read check
			if ( ! key_exists( 'error', $list ) ) {

				// Data
				$categories = Category::all();
				$count 		= $categories->count();

				// Count current SpreadSheet category rows 
				foreach ( $list as $i => &$row ) {
					if ( is_array( $row ) ) {

						if(count($row) == 0){
							continue;
						}

						if ( strpos(strtolower( $row[0] ),"section") === 0) {
							break;
						}
					}
				}

				// Count rows need to append
				$append		= $count - ($i - 2);
				if ($append > 0) {
					$append_empty_rows = array();
					for ($j=0; $j < $append; $j++) { 
						$append_empty_rows[] = array('');
					}
					// Append empty rows
					$status = $Google->getSpreadSheet( $spreadSheetId )->Append("Main!".$i.":".$i, $append_empty_rows);
				} else {
					// Write empty rows
					$status = $Google->getSpreadSheet( $spreadSheetId )->Clear("Main!2:".$i);
					// $status = $Google->getSpreadSheet( $spreadSheetId )->Delete("Main!9:9");
					// dd($status);
				}
				
				// Prepare data for export
				$rows = array();
				foreach ($categories as $key => $category) {
					$row = array($key + 1, $category->categoryName, '');
					foreach ($category->subCategories as $key => $subCategory) {
						$row[] = $subCategory->subCategoryName;
					}
					$rows[] = $row;
				}
				$rows[] = array();
				
				// Export
				$status = $Google->getSpreadSheet( $spreadSheetId )->Write("Main!2:".($count + 1), $rows);
				// dump( $Google->getSpreadSheet("1qV3YQxaHVLNRsvi1vSltzHU4QrBOengxPMahmR2sovY")->Write("Main!2:".($categories->count() + 1), $rows) ); 

				// Write check
				if (!key_exists('error', $status))
					return response()->json(['status' => 'success', 'message' => $status]);
				else
					return response()->json($status, 403);
			}
			else
				return response()->json($status, 403);
		}
	}

	public function saveAuth( Request $request ) {

		$req = $request->validate( [

			'code' => 'required|string',

		] );

		$Google = new GoogleSheets();

		$accessToken = $Google->Client()->fetchAccessTokenWithAuthCode( $req['code'] );

		Option::setSetting( "opt_google_sheets_token", json_encode( $accessToken ) );

		return redirect( "/admin/google-sheets" );

	}

}
