<?php

namespace App\Http\Controllers\User;

use App\Activity;
use App\Ads;
use App\Category;
use App\City;
use App\Color;
use App\Condition;
use App\Country;
use App\Filter;
use App\Language;
use App\Option;
use App\Size;
use App\SubCategory;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use App\Traits\PaginationCollection;

class SellsController extends BaseController
{
    use PaginationCollection;

    public function sellNow()
    {
        $priceTypes    = ['EUR' => 'EUR', 'USD' => 'USD', 'GBP' => 'GBP'];
        $categories    = Category::pluck('categoryName', 'id');
        $category      = Category::first();
        $subCategories = $category->subCategories;

        return view('site.sells.sellNow', compact('categories', 'priceTypes', 'subCategories'));
    }

    public function ads(string $filter)
    {
        $user         = auth()->user();
        $websiteSince = Carbon::parse($user->created_at)->format('d.m.y');

        switch ($filter) {
            case 'expired':
                $filter     = 'expired';
                $ads        = $user->Ads->where('expired_at', '<', Carbon::now())->where('adsStatus', '<>', 'sold');
                $itemTarget = 'Sell Items';
                $itemsList  = ['bought' => 'Bought Items', 'favorites' => 'Favorite Items'];
                break;
            case 'sold':
                $filter     = 'sold';
                $ads        = $user->Ads->where('adsStatus', 'sold');
                $itemTarget = 'Sell Items';
                $itemsList  = ['bought' => 'Bought Items', 'favorites' => 'Favorite Items'];
                break;
            case 'favorites':
                $filter     = 'favorites';
                $ads        = $user->favoriteAds->where('expired_at', '>', Carbon::now())->where('adsStatus', '<>', 'sold');
                $itemTarget = 'Favorite Items';
                $itemsList  = ['bought' => 'Bought Items', 'published' => 'Sell Items'];
                break;
            case 'bought':
                $filter = 'bought';
                $ads    = new Collection();

                foreach ($user->buyer_activities as $buyer_activity) {
                    if ($buyer_activity->ads !== null && $buyer_activity->ads->adsStatus == 'sold') {
                        $ads->push($buyer_activity->ads);
                    }
                }

                $itemTarget = 'Bought Items';
                $itemsList  = ['published' => 'Sell Items', 'favorites' => 'Favorite Items'];
                break;
            default :
                $filter     = 'published';
                $ads        = $user->Ads->where('adsStatus', '!=', 'sold')->where('expired_at', '>', Carbon::now());
                $itemTarget = 'Sell Items';
                $itemsList  = ['bought' => 'Bought Items', 'favorites' => 'Favorite Items'];
                break;
        }

        $followers = collect();
        foreach ($user->followers->sortByDesc('id') as $follower) {
            $followers->push(User::find($follower->saved_userId));
        }

        $ads              = $this->paginate_collection($ads, 12);
        $activitiesSeller = $user->getActivity('seller');
        $activitiesBuyer  = $user->getActivity('buyer');

        return view('site.sells.ads', compact('user', 'websiteSince', 'ads', 'filter', 'followers', 'itemTarget', 'itemsList', 'activitiesSeller', 'activitiesBuyer'));
    }

    public function addSell(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'adsName'        => 'required|string',
            'adsPrice'       => 'required|numeric|between:0,9999.99',
            'categoryId'     => 'required|integer',
            'subCategoryId'  => 'required|integer',
            'original_price' => 'nullable|numeric|between:0,999999.99',
            //            'payment' => 'required',
            'adsDescription' => 'required',
            'swap'           => 'required',
            'adsImages'      => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'errorValidation',
                'message' => $validator->errors()->messages(),
            ]);
        }

        $adWillCost = floatval(Option::getSetting("opt_pack_basic"));
        $user       = auth()->user();

        if ($user->wallet >= $adWillCost) {
            $user->wallet = $user->wallet - $adWillCost;
            $user->save();
        } else {
            return response()->json([
                'status'  => 'error',
                'message' => 'Error! Insufficient funds',
            ]);
        }

        $ads = new Ads();
        $ads->add($request->all());

        return response()->json(['status' => 'success']);
    }

    public function getCategories($id)
    {
        $category      = Category::find($id);
        $subCategories = isset($category) ? $category->subCategories : [];

        return response()->json(['success' => true, 'data' => $subCategories]);
    }

    public function getFilters($id, $locale)
    {
        app()->setLocale($locale);
        $subCategory = SubCategory::find($id);
        $filters     = [];
        foreach ($subCategory->adsFilters()->get() as $filter) {
            $subFilters = [];
            if (!empty($filter->children()->get())) {
                foreach ($filter->children()->get() as $subFilter) {
                    $subFilters[] = [$subFilter->id, $subFilter->name];
                }
            }
            $filters[] = [
                'name'     => Language::lang($filter->name),
                'template' => $filter->template,
                'value'    => $subFilters
            ];
        }
        return response()->json(['success' => true, 'data' => $filters ?? null]);
    }

    public function getSubFilters($filterId)
    {
        $filter = Filter::find($filterId);
        if ($filter !== null) {
            if ($filter->parent !== null && $filter->parent->template == "brand" && $filter->name == "Other") {
                $data = [
                    'name'     => Language::lang($filter->name),
                    'template' => $filter->template,
                    'value'    => ['id' => $filter->id, 'name' => 'other-brand']
                ];
            } else {
                $data = [
                    'name'  => Language::lang($filter->name),
                    'value' => !empty($filter->children()->get()) ? $filter->children()->get()->pluck('name', 'id') : ''
                ];
            }


            return response()->json(['success' => true, 'data' => $data]);
        }

        return response()->json(['success' => true, 'Filter not found', null]);

    }

    public function getSubFiltersBrand($currentFilter, $filterId)
    {
        $filter = Filter::find($filterId);
        if ($filter !== null) {
            if ($filter->parent !== null && $filter->parent->template == "brand" && $filter->name == "Other") {
                $brand = Filter::find($currentFilter);
                $data  = [
                    'name'  => Language::lang($filter->name),
                    'value' => ['id' => $filter->id, 'name' => 'other-brand', 'brand' => $brand !== null ? $brand->name : '']
                ];
            } else {
                $data = [
                    'name'  => Language::lang($filter->name),
                    'value' => !empty($filter->children()->get()) ? $filter->children()->get()->pluck('name', 'id') : ''
                ];
            }


            return response()->json(['success' => true, 'data' => $data]);
        }

        return response()->json(['success' => true, 'Filter not found', null]);

    }

    public function product($id, Request $request)
    {
        $product = Ads::find($id);
        if ($product->adsStatus == 'sold') {
            $activity = $product->activities->first();

            if (auth()->user() == null) {
                abort(404);
            }

            if (auth()->user()->id !== $product->userId) {
                if ($activity !== null && $activity->status == 'success') {
                    if (auth()->user()->id !== $activity->buyer_id) {
                        abort(404);
                    }
                } else {
                    abort(404);
                }
            }
        }

        $product->increment('adsViews');
        $ip = $request->ip();
        $product->addUserView($ip);
        $user       = $product->checkThisUser() ? auth()->user() : $product->UserAds;
        $ads        = $user->Ads()
            ->where('id', '!=', $id)
            ->availableForSale()
            ->with(['images'])
            ->paginate(9);
        $filters    = $product->filters()->get()->map(function ($item) {
            if ($item->parent()->first()->name == 'Other') {
                return [
                    'name'  => $item->parent()->first()->parent()->first()->name,
                    'value' => $item->name
                ];
            }
            if ($item->parent()->first()->template == 'brand' && $item->name == 'Other') {
                return [];
            }
            return [
                'name'  => $item->parent()->first()->name,
                'value' => $item->name
            ];
        })->reject(function ($item) {
            return empty($item);
        });
        $activities = $user->getActivity('seller');

        return view('site.product', compact('product', 'ads', 'user', 'filters', 'activities'));
    }

    public function deleteProduct(Request $request)
    {
        $curUser = Auth::user();

        $adsId = $request->adsId;

        Ads::find($adsId)->delete();

        $curUser->sendNotification('Product deleted');

        return response()->json([
            'status'  => 'success',
            'message' => 'Product deleted',
        ]);
    }

    public function firstListed(Request $request)
    {
        $firstList = floatval(Option::getSetting("opt_pack_spotlight"));
        $user      = auth()->user();

        if ($user->wallet > $firstList) {
            $ads = Ads::find($request->adsId);

            if ($ads->firstList == 1) {
                $user->sendNotification('Error! You already did it');

                return response()->json([
                    'status'  => 'error',
                    'message' => 'Error! You already did it',
                ]);
            } else {
                $ads->firstList       = 1;
                $ads->first_listed_at = Carbon::now();
                $ads->save();
            }

            $user->wallet = $user->wallet - $firstList;
            $user->save();

            $user->sendNotification('Success! Made first listed');

            return response()->json([
                'status'  => 'success',
                'message' => null,
            ]);
        }

        $user->sendNotification('Error! Insufficient funds');

        return response()->json([
            'status'  => 'error',
            'message' => 'Error! Insufficient funds',
        ]);
    }

    public function extendProduct(Request $request)
    {
        $extendProduct = floatval(Option::getSetting("opt_pack_basic"));
        $user          = auth()->user();

        if ($user->wallet > $extendProduct) {
            $user->wallet = $user->wallet - $extendProduct;
            $user->save();

            $ads             = Ads::find($request->adsId);
            $ads->expired_at = Carbon::parse($ads->expired_at)->addDay(30);
            $ads->save();

            return response()->json([
                'status'  => 'success',
                'message' => 'Success! Product extended by 30 days!',
            ]);
        }
        return response()->json([
            'status'  => 'error',
            'message' => 'Error! Insufficient funds',
        ]);
    }

    public function editSell($sell)
    {
        $priceTypes = ['EUR' => 'EUR', 'USD' => 'USD', 'GBP' => 'GBP'];
        $categories = Category::pluck('categoryName', 'id');

        $ads           = Ads::find($sell);
        $subcategory   = SubCategory::find($ads->subCategoryId) ?? null;
        $category      = $subcategory->Category;
        $subCategories = isset($category) ? $category->subCategories->pluck('subCategoryName', 'id') : [];
        /*$countries = Country::all();
        $city = City::where('name', $ads->adsCity)->first();
        $country = $city->country ?? null;
        $cities = isset($country) ? $country->cities->pluck('name', 'name') : [];*/

        $filters = [];
        foreach ($subcategory->adsFilters()->get() as $filter) {
            $currentFilter = array_intersect(
                $filter->children()->get()->pluck('id')->toArray(),
                $ads->filters()->get()->pluck('id')->toArray()
            );
            $filters[]     = [
                'name'     => $filter->name,
                'template' => $filter->template,
                'list'     => $filter->children()->get()->pluck('name', 'id')->toArray(),
                'current'  => $currentFilter ?? null
            ];
        }

        return view('site.sells.editSell', compact(
            'categories',
            'priceTypes',
            'ads',
            'category',
            'subcategory',
            'subCategories',
            /*'countries',
            'cities',
            'city',
            'country',
            'countryAttributes',*/
            'filters'
        ));
    }

    public function updateSell($sell, Request $request)
    {
        $v = Validator::make($request->all(), [
            'adsName'        => 'required|string',
            'adsPrice'       => 'required|numeric|between:0,9999.99',
            'categoryId'     => 'required|integer',
            'subCategoryId'  => 'required|integer',
            /*'adsCountry' => 'required',
            'adsCity' => 'required',*/
            'original_price' => 'numeric|between:0,999999.99',
            //            'payment' => 'required',
            'adsDescription' => 'required',
            'swap'           => 'required',
            'adsImages'      => 'required'
        ]);

        if ($v->fails()) {
            return response()->json([
                'status'  => 'errorValidation',
                'message' => $v->errors()->messages()
            ]);
        }

        $ads = Ads::findOrFail($sell);
        $ads->add($request->all());

        return response()->json([
            'status' => 'success',
        ]);
    }

    /*public function favorites()
    {
        $ads = Auth::user()->favoriteAds;

        return view('site.pages.favorites', compact('ads'));
    }*/

}
