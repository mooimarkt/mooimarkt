<?php

namespace App\Http\Controllers;

use Auth;
use App\Activity;
use App\Ads;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActivityController extends Controller
{
    public function show(Activity $activity)
    {
        return response()->json([
            'data' => $activity,
        ], 200);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        $ads = Ads::find($request->ads_id);
        $adsUserId = $ads->userId;

        if (($request->buyer_id == $user->id) || ($adsUserId == $user->id)) {
            if ($ads->adsStatus === 'sold') {
                return response()->json([
                    'status' => 'ads_sold',
                    'error'  => $ads->adsName . ' has already been sold',
                    'data'   => ['ads_id' => $ads->id],
                ], 403);
            }

            $buyer = User::find($request->buyer_id);

            $activity = Activity::create([
                'ads_id'           => $request->ads_id,
                'seller_id'        => $adsUserId,
                'seller_confirmed' => $buyer->id !== $user->id ? true : null,
                'buyer_id'         => $request->buyer_id,
                'buyer_confirmed'  => $buyer->id === $user->id ? true : null,
                'content'          => $request['content'],
                'location'         => $request->location,
                'status'           => 'waiting',
                'type'             => $request->type == 'shipping' ? 'shipping' : 'meeting',
                'meeting'          => $request->meeting,
                'seller_mark'      => $request->seller_mark ?? null,
                'seller_comment'   => $request->seller_comment ?? null,
            ]);

            $notifiableUserProfileActivityUrl = route('profile.show', [$user->id]);
            $message = '<a href="'
                . $notifiableUserProfileActivityUrl . '">'
                . $user->name
                . '</a> '
                . trans('translation.confirm_sale.notifications.seller', [
                    'seller' => $user->name,
                    'product' => $ads->adsName,
                    'id' => $activity->id,
                    'profileUrl' => $notifiableUserProfileActivityUrl,
                ]);
            $picture = [
                'src'  => $user->avatar,
                'link' => $notifiableUserProfileActivityUrl,
            ];
            $buyer->saveNotification($message, $picture);

            return response()->json([
                'status'  => 'ads_seller_sell_request_sent',
                'success' => 'Activity created!',
                'data'    => ['ads_id' => $ads->id],
            ]);
        }

        return response()->json(['error' => 'No access'], 403);
    }

    /**
     * @param Request $request
     * @param Activity $activity
     * @return mixed
     */
    public function update(Request $request, Activity $activity)
    {
        $ads = Ads::find($activity->ads_id);

        if ($activity->seller_confirmed === 1 && $activity->buyer_id !== auth()->user()->id) {
            return response()->json([
                'status' => 'ads_sold',
                'error'  => $ads->adsName . ' has already been sold',
                'data'   => ['activity_id' => $activity->id],
            ], 403);
        }

        if ($activity->buyer_id === Auth::id() || $activity->seller_id === Auth::id()) { // Check can user make update of this activity (only seller, buyer have access)
            if (isset($request->mark)) { // if mark not empty save this, else try confirm meeting
                if ($activity->meeting < date("Y-m-d H:i:s")) { // Check the date of the meeting > today
                    if ($activity->buyer_confirmed && $activity->seller_confirmed) { // Upate only confirmed activity
                        if ($activity->buyer_id == Auth::id()) {
                            if ($activity->buyer_mark === null) { // Check if mark was been put before
                                DB::transaction(function () use (&$activity, &$request) { // correct execution of both update requests
                                    $activity->update([
                                        'buyer_mark' => $request->mark,
                                    ]); // Rate seller by buyer
                                    User::where('id', $activity->seller_id)->first()->increment('level', $request->mark); // Update seller level
                                });
                            } else return response()->json(['error' => 'You can\'t mark seller twice'], 403);
                        } else {
                            if ($activity->seller_mark === null) { // Check if mark was been put before
                                DB::transaction(function () use (&$activity, &$request) { // correct execution of both update requests
                                    $activity->update([
                                        'seller_mark' => $request->mark,
                                    ]); // Rate buyer by seller
                                    User::where('id', $activity->buyer_id)->first()->increment('level', $request->mark); // Update buyer level
                                });
                            } else return response()->json(['error' => 'You can\'t mark buyer twice'], 403);
                        }

                        return response()->json([
                            'success' => 'Mark saved!',
                            'mark'    => $request->mark
                        ]);
                    } else return response()->json(['error' => 'You can\'t mark cancelled activity'], 403);
                } else return response()->json(['error' => 'Meeting has not yet taken place'], 403);
            } else { // confirmation meeting|shipping
                if ($activity->buyer_id === Auth::id()) {
                    if (!empty($request->rating)) {
                        $activity->update([
                            'buyer_confirmed' => $request->confirm === 'true',
                            'status'          => $request->confirm === 'true' ? 'success' : 'cancel',
                            'buyer_mark'      => $request->rating,
                            'comment'         => $request->comment ?? null,
                        ]);

                        $buyer = Auth::user();
                        $notifiableUserProfileActivityUrl = route('profile.show', [$buyer->id]);
                        $message = '<a href="'
                            . $notifiableUserProfileActivityUrl . '">'
                            . $buyer->name
                            . '</a> '
                            . trans('translation.confirm_sale.notifications.buyer', [
                                'buyer' => $buyer->name,
                                'product' => $ads->adsName,
                                'link' => route('profile.show', [$activity->seller_id, 'seller']),
                                'profileUrl' => $notifiableUserProfileActivityUrl,
                            ]);
                        $picture = [
                            'src'  => $buyer->avatar,
                            'link' => $notifiableUserProfileActivityUrl,
                        ];
                        $seller = User::find($activity->seller_id);
                        $seller->saveNotification($message, $picture);

                    } else {
                        return response()->json(['error' => 'Please select a rating'], 403);
                    }
                } else {
                    $activity->update([
                        'seller_confirmed' => $request->confirm == 'true',
                        'status'           => ($request->confirm == 'true') ? 'success' : 'cancel'
                    ]);
                }

                if ($request->confirm === 'true') {
                    $ads = Ads::find($activity->ads_id);

                    if (isset($ads->adsStatus) && $ads->adsStatus === 'payed') {
                        $ads->adsStatus = "sold";
                        $ads->save();

                        $this->sendAdsSoldNotification($ads->UserAds, $ads);
                    }
                }

                return response()->json([
                    'success'   => 'Activity ' . (($request->confirm === 'true') ? 'confirmed' : 'cancelled') . '!',
                    'confirmed' => ($request->confirm === 'true') ? 1 : 0
                ]);
            }
        } else {
            return response()->json(['error' => 'No access'], 403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Activity $activity
     * @return \Illuminate\Http\Response
     */
    public function destroy(Activity $activity)
    {
        $activity->delete();
        return response()->json([
            'status' => 'success',
            'msg'    => 'Activity deleted!'
        ]);
    }

    private function sendAdsSoldNotification(User $notifiableUser, Ads $ads)
    {
        $adsUrl  = route('product', $ads->id);
        $message = '<a href="' . $adsUrl . '">' . $ads->adsName . '</a> has been successfully sold!';
        $picture = [
            'src'  => $ads->images->first()->thumb ?? '/mooimarkt/img/photo_camera.svg',
            'link' => $adsUrl,
        ];

        $notifiableUser->saveNotification($message, $picture);
    }
}
