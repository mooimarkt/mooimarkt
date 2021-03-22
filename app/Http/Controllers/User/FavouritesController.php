<?php

namespace App\Http\Controllers\User;

// use App\ForDisplay;
// use Illuminate\Support\Facades\DB;
// use App\Wishlist;
use App\Ads;
use App\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller as BaseController;

class FavouritesController extends BaseController
{

    /**
     * Display the favourite user resource.
     *
     * @param  \App\Ads  $ads
     * @return \Illuminate\Http\Response
     */
    public function favorite()
    {
        return view('newthemplate.my-favorite', compact(['favoriteAds']));
    }

    /**
     * add item to favorites
     * @param  int    $id   favoritable_id
     * @param  string $type favoritable_type
     * @return [type]       [description]
     */
    public function add($id, $type)
    {
        $favourite  = Favorite::create([
            'user_id' => Auth::id(),
            'favoritable_id' => $id,
            'favoritable_type' => $type,
        ]);
        return response()->json(['success' => $favourite, 'type' => $type]);
    }

    /**
     * delete item from favorites
     * @param  int    $id   favoritable_id
     * @param  string $type favoritable_type
     * @return [type]       [description]
     */
    public function delete($id, $type)
    {
        $result = Favorite::where([
            ['user_id', Auth::id()],
            ['favoritable_id', $id],
            ['favoritable_type', $type],
        ])->delete();
        return response()->json(['success' => $result, 'type' => $type]);
    }

    // public function getFavouritesPage(Request $request){

    //     $checkMethod = $request->input('btnMethod');
    //     $userId = Auth::user()->id;
    //     $wishlist = Wishlist::where('userId', $userId)->get();

    //     if($checkMethod == 'active'){

    //         $ads = DB::table('ads')
    //             ->join('sub_categories', 'sub_categories.id', '=', 'ads.subCategoryId')
    //             ->join('wishlists', 'ads.id', '=', 'wishlists.adsId')
    //             ->where('wishlists.userId', '=', $userId)
    //             ->where('wishlists.wishlistStatus', '=', 'active')
    //             ->where('ads.adsStatus', '!=',   'unavailable')
    //             ->where('wishlists.wishlistStatus', 'active')
    //             ->paginate(8);
    //     }
    //     else if($checkMethod == 'sold'){

    //         $ads = DB::table('ads')
    //             ->join('sub_categories', 'sub_categories.id', '=', 'ads.subCategoryId')
    //             ->join('wishlists', 'ads.id', '=', 'wishlists.adsId')
    //             ->where('wishlists.userId', '=', $userId)
    //             ->where('wishlists.wishlistStatus', '=', 'active')
    //             ->where('ads.adsStatus', '!=',   'unavailable')
    //             ->where('wishlists.wishlistStatus', 'sold')
    //             ->paginate(8);
    //     }
    //     else{

    //         $ads = DB::table('ads')
    //             ->join('sub_categories', 'sub_categories.id', '=', 'ads.subCategoryId')
    //             ->join('wishlists', 'ads.id', '=', 'wishlists.adsId')
    //             ->where('wishlists.userId', '=', $userId)
    //             ->where('wishlists.wishlistStatus', '=', 'active')
    //             ->where('ads.adsStatus', '!=',   'unavailable')
    //             ->where('wishlists.wishlistStatus', '!=', 'unavailable')
    //             ->paginate(8);
    //     }

    //     return view('user/favourites', ["ads" => $ads, "checkMethod" => $checkMethod]);
    // }

    // public function deleteFavourite(Request $request){

    //     $id = $request->input('id');

    //     $favourite = Wishlist::find($id);

    //     $favourite->wishlistStatus = "unavailable";
    //     $favourite->save();

    //     return response()->json(['success' => 'success']);
    // }

    // public function addFavourite(Request $request){

    //     $adsId = $request->input('adsId');
    //     $userId = Auth::user()->id;

    //     $wishlist = Wishlist::where('adsId', $adsId)
    //                         ->where('userId', $userId)
    //                         ->first();

    //     if($wishlist == null){

    //         $favourite = new Wishlist;

    //         $favourite->userId = $userId;
    //         $favourite->adsId = $adsId;
    //         $favourite->wishlistStatus = "active";

    //         $favourite->save();

    //         $result = 'success';
    //         $type = 'active';
    //     }
    //     else{

    //         $wishListId = $wishlist->id;

    //         if($wishlist->wishlistStatus == "active"){
    //             $favourite = Wishlist::find($wishListId);
    //             $favourite->wishlistStatus = "unavailable";
    //             $favourite->save();

    //             $result = 'success';
    //             $type = 'unavailable';
    //         }
    //         else{
    //             $favourite = Wishlist::find($wishListId);
    //             $favourite->wishlistStatus = "active";
    //             $favourite->save();

    //             $result = 'success';
    //             $type = 'active';
    //         }
    //     }

    //      return response()->json(['success' => $result, 'type' => $type]);

    // }




    public function toggle($id)
    {
        if (!auth()->check()) {
            return response()->json(['success' => 'error', 'message' => 'You are not authorized']);
        }

        $user = auth()->user();
        $ads = Ads::find($id);
        $favourites = $ads->favorites()->where('user_id', $user->id)->get();
        $url = route('product', $id);

        $picture = [
            'src' => $ads->images->first()->thumb ?? '/mooimarkt/img/notification_def_img.svg',
            'link' => $url
            ];

        if ($favourites->isEmpty()) {
            $ads->favorites()->create([
                'user_id' => $user->id
            ]);
            $ads->UserAds->saveNotification('<a href="'.route('profile.show', $user->id).'">'.$user->name.'</a> added your product ' . '<a href="'.$url.'">'.$ads->adsName.'</a> ' . ' to favorites', $picture);

            return response()->json([
                'success' => 'success',
                'action' => 'add',
                'id' => $id,
                'count' => $ads->favorites->count(),
//                'message' => 'Product added to favorites !'
            ]);
        } else {
            $ads->favorites()->where('user_id', $user->id)->delete();

            $ads->UserAds->saveNotification('<a href="'.route('profile.show', $user->id).'">'.$user->name.'</a> removed your product ' . '<a href="'.$url.'">'.$ads->adsName.'</a> ' . ' from favorites', $picture);

            return response()->json([
                'success' => 'success',
                'action' => 'delete',
                'id' => $id,
                'count' => $ads->favorites->count(),
//                'message' => 'Product removed from favorites !'
            ]);
        }
    }
}
