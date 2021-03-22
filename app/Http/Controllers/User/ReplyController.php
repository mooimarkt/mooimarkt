<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\ForDisplay;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Chat;
use App\Inbox;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\ChatMail;
use App\Http\Controllers\Controller as BaseController;

class ReplyController extends BaseController
{
    
    public function getReplyPage(Request $request){

        $inboxId = $request->input('inboxId');
        $userId = Auth::user()->id;

        $ads = DB::table('inbox')
                ->join('ads', 'ads.id', '=', 'inbox.adsId')
                ->join('sub_categories', 'sub_categories.id', '=', 'ads.subCategoryId')
                ->join('users', 'users.id', '=', 'inbox.userID')
                ->where('inbox.id', '=', $inboxId)
                ->where('ads.adsStatus', '!=',   'unavailable')
                ->select('sub_categories.subCategoryName','ads.adsName','ads.adsRegion','ads.adsCountry','ads.adsImage', 'ads.adsPriceType', 'ads.adsPrice', 'users.name', 'users.id', 'inbox.adsId')
                ->get();

        $chats = Chat::where('inboxId', $inboxId)->get();
        $affected = DB::table('chats')->where('inboxId', '=', $inboxId)->update(array('seen' => 1));

        
        return view('user/replyinbox',["chats" => $chats, "ads" => $ads, "currentId" => $userId, "inboxId" => $inboxId]);
    }

    public function replyMessage(Request $request){

        $currentUserId = Auth::user()->id;

        $targetUserId = $request->input('targetUserId');
        $targetInboxId = $request->input('targetInboxId');
        $message = $request->input('message');
        if(!trim($message)){
            $result = array('success' => 1);
            return $result;
        }
        $adsId = $request->input('adsId');

        $userInbox = Inbox::find($targetInboxId);
        //$userInbox = Inbox::find($targetInboxId);
        $userInbox->inboxStatus = "active";
        $userInbox->lastMsgTs = date("Y-m-d H:i:s");
        $userInbox->save();

        $chat = new Chat;
        //own msg ///
        $chat->userID = $currentUserId;
        $chat->senderID = $currentUserId;
        $chat->inboxId = $targetInboxId;
        $chat->message = $message;
        $chat->seen = "1";
        $chat->isSender = 'true';

        $chat->save();

        

        $inbox = Inbox::where('userID', $userInbox->toID)
                        ->where('toID', $userInbox->userID)
                        ->where('adsId', $adsId)
                        ->get();


        
        // recipient msg
        foreach($inbox as $inboxData){
            $secondChat = new Chat;

            $secondChat->userID = $inboxData->userID;
            $secondChat->senderID = $currentUserId;
            $secondChat->inboxId = $inboxData->id;
            $secondChat->message = $message;
            $secondChat->isSender = 'false';

            $secondChat->save();

            $inboxChangeState2 = Inbox::find($inboxData->id);
            $inboxChangeState2->inboxStatus = "active";
            $inboxChangeState2->lastMsgTs = date("Y-m-d H:i:s");
            $inboxChangeState2->save();
        }

        $receiver = User::find($targetUserId);
        $sender = User::find($currentUserId);

        //Mail::to($receiver->email)->send(new ChatMail($sender, $receiver));

        $result = array('success' => 1);
        return $result;
    }
}