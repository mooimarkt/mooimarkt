<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\ForDisplay;
use App\User;
use App\Ads;
use App\Chat;
use App\Inbox;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use App\Http\Controllers\Controller as BaseController;

class InboxController extends BaseController
{
    
    public function getInboxPage(Request $request){

        $currentUser = Auth::user()->id;

        $checkMethod = $request->input('btnMethod');

        
        $chat_array = array();
        /*foreach($inbox as $inbo){
            $array['chats'] = Chat::orderBy('created_at', 'desc')
            ->where('inboxId', $inbo->id)
            ->first();

            $chat_array[] = $array;
        }*/

        if($checkMethod == 'archive'){
            $inbox = Inbox::WHERE("userID","=",$currentUser)->where("inboxStatus","=","archive")->orderBy("lastMsgTs","DESC")->paginate(8);

            /*$ads = DB::table('inbox')
                ->join('ads', 'ads.id', '=', 'inbox.adsId')
                ->join('sub_categories', 'sub_categories.id', '=', 'ads.subCategoryId')
                ->join('users', 'users.id', '=', 'inbox.userID')
                ->where('inbox.userID', '=', $currentUser)
                ->where('ads.adsStatus', '!=',   'unavailable')
                ->where('inbox.inboxStatus', 'archive')
                ->select('inbox.id','ads.adsName','sub_categories.subCategoryName','ads.adsRegion','ads.adsCountry','ads.adsImage', 'users.name')
                ->paginate(8);*/
        }
        else{
            $inbox = Inbox::WHERE("userID","=",$currentUser)->where("inboxStatus","=","active")->orderBy("lastMsgTs","DESC")->paginate(8);
            /*$ads = DB::table('inbox')
                ->join('ads', 'ads.id', '=', 'inbox.adsId')
                ->join('sub_categories', 'sub_categories.id', '=', 'ads.subCategoryId')
                ->join('users', 'users.id', '=', 'inbox.userID')
                ->where('inbox.toID', '=', $currentUser)
                ->where('ads.adsStatus', '!=',   'unavailable')
                ->where('inbox.inboxStatus', 'active')
                ->select('inbox.id','ads.adsName','ads.adsRegion','ads.adsCountry','ads.adsImage', 'users.name')
                ->paginate(8);*/
        }

        return view('user/inbox',["ads" => [], "chatsArray" => $chat_array, "checkMethod" => $checkMethod,"inbox"=>$inbox]);
    }

    public function createNewInbox(Request $request){

        $currentUser = Auth::user()->id;
        $adsId = $request->input('adsId');
        $senderUser = $request->input('senderUserId');


        $checkInbox = Inbox::where('userID', $currentUser)
                            ->where('toID', $senderUser)
                            ->where('adsId', $adsId)
                            ->get();

        if($checkInbox->count() < 1){

            $createInbox = new Inbox;

            $createInbox->userID = $currentUser;
            $createInbox->toID = $senderUser;
            $createInbox->adsId = $adsId;
            $createInbox->inboxStatus = 'active';

            $createInbox->save();

            $createInbox2 = new Inbox;

            $createInbox2->toID = $currentUser;
            $createInbox2->userID = $senderUser;
            $createInbox2->adsId = $adsId;
            $createInbox2->inboxStatus = 'active';

            $createInbox2->save();

            $currentInboxId = $createInbox->id;

            $ads = DB::table('inbox')
                    ->join('ads', 'ads.id', '=', 'inbox.adsId')
                    ->join('sub_categories', 'sub_categories.id', '=', 'ads.subCategoryId')
                    ->join('users', 'users.id', '=', 'inbox.userID')
                    ->where('inbox.id', '=', $currentInboxId)
                    ->where('ads.adsStatus', '!=',   'unavailable')
                    ->select('sub_categories.subCategoryName','ads.adsName','ads.adsRegion','ads.adsCountry','ads.adsImage','ads.adsPriceType', 'ads.adsPrice', 'users.name', 'users.id', 'inbox.adsId')
                    ->get();

            $chats = Chat::where('inboxId', $currentInboxId)->get();
            
            return view('user/replyinbox',["chats" => $chats, "ads" => $ads, "currentId" => $senderUser, "inboxId" => $currentInboxId]);
        }

        else{


            $checkInboxQuery = Inbox::where('toID', $currentUser)
                            ->where('userID', $senderUser)
                            ->where('adsId', $adsId)
                            ->get();

            $currentInboxId = 0;

            foreach($checkInboxQuery as $inbox){

                $currentInboxId = $inbox->id;
            }

            $ads = DB::table('inbox')
                    ->join('ads', 'ads.id', '=', 'inbox.adsId')
                    ->join('sub_categories', 'sub_categories.id', '=', 'ads.subCategoryId')
                    ->join('users', 'users.id', '=', 'inbox.userID')
                    ->where('inbox.id', '=', $currentInboxId)
                    ->where('ads.adsStatus', '!=',   'unavailable')
                    ->select('sub_categories.subCategoryName','ads.adsName','ads.adsRegion','ads.adsCountry','ads.adsImage', 'ads.adsPriceType', 'ads.adsPrice', 'users.name', 'users.id', 'inbox.adsId')
                    ->get();

            $chats = Chat::where('inboxId', $currentInboxId)->get();
            
            return view('user/replyinbox',["chats" => $chats, "ads" => $ads, "currentId" => $currentUser, "inboxId" => $currentInboxId]);
        }
    }

    public function deleteInbox(Request $request){
        
        $allId = $request->input('allId');

        foreach($allId as $id){

            $inbox = Inbox::find($id);
            $inbox->inboxStatus = "unavailable";
            $inbox->save();
        }

        return response()->json(['success' => 'success']);
    }

    public function archiveInbox(Request $request){

        $allId = $request->input('allId');

        foreach($allId as $id){

            $inbox = Inbox::find($id);
            $inbox->inboxStatus = "archive";
            $inbox->save();
        }

        return response()->json(['success' => 'success']);
    }

    public function getInboxPageByName($name, $checkMethod){

        $currentUser = Auth::user()->id;

        //$checkMethod = $request->input('btnMethod');

        $inbox = Inbox::all();
        $chat_array = array();

        foreach($inbox as $inbo){

            $array['chats'] = Chat::orderBy('created_at', 'desc')
            ->where('inboxId', $inbo->id)
            ->first();

            $chat_array[] = $array;
        }

        if($checkMethod == 'archive'){

            $ads = DB::table('inbox')
                ->join('ads', 'ads.id', '=', 'inbox.adsId')
                ->join('sub_categories', 'sub_categories.id', '=', 'ads.subCategoryId')
                ->join('users', 'users.id', '=', 'inbox.userID')
                ->where('inbox.toID', '=', $currentUser)
                ->where('ads.adsStatus', '!=',   'unavailable')
                ->where('inbox.inboxStatus', 'archive')
                ->where('users.name','like', '%'.$name.'%')
                ->select('inbox.id','sub_categories.subCategoryName','ads.adsName','ads.adsRegion','ads.adsCountry','ads.adsImage', 'users.name')
                ->paginate(5);
        }
        else{
            $ads = DB::table('inbox')
                ->join('ads', 'ads.id', '=', 'inbox.adsId')
                ->join('sub_categories', 'sub_categories.id', '=', 'ads.subCategoryId')
                ->join('users', 'users.id', '=', 'inbox.userID')
                ->where('inbox.toID', '=', $currentUser)
                ->where('ads.adsStatus', '!=',   'unavailable')
                ->where('inbox.inboxStatus', 'active')
                ->where('users.name','like', '%'.$name.'%')
                ->select('inbox.id','ads.adsName','ads.adsRegion','ads.adsCountry','ads.adsImage', 'users.name')
                ->paginate(5);
        }

        return view('user/inbox',["ads" => $ads, "chatsArray" => $chat_array, "checkMethod" => $checkMethod]);
    }
}