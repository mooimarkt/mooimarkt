<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\DB;
use Chat;
use Illuminate\Database\Eloquent\Model;
use Musonza\Chat\Traits\Messageable;
use App\User;
use App\Ads;

class ChatController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function GetChat(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'adId' => 'required|integer',
        ]);

        if ($validator->fails() || !Auth::check()) {
            return response()->json(['status' => 'error', 'code' => 1]);
        }

        $ad = DB::table('ads')
            ->where('id', $request->input('adId'))
            ->whereNull('deleted_at')
            ->first();

        if ($ad === null) {
            return response()->json(['status' => 'error', 'code' => 2]);
        }

        $user_id = $ad->userId;
        if (Auth::id() == $user_id) {
            return response()->json(['status' => 'error', 'code' => 3]);
        }

        $my_conversations = DB::table('mc_conversation_user')
            ->where('user_id', Auth::user()->id)
            ->get();
        $conversation     = null;
        if (count($my_conversations) > 0) {
            $conversations = [];

            foreach ($my_conversations as $conv) {
                $conversations[] = $conv->conversation_id;
            }

            $conversations_with_user = [];
            foreach ($conversations as $conv) {
                $conv = DB::table('mc_conversation_user')
                    ->where('user_id', $user_id)
                    ->where('conversation_id', $conv)
                    ->first();

                if ($conv !== null) {
                    $conversations_with_user[] = $conv->conversation_id;
                }
            }

            $conversation_id = false;
            if (count($conversations_with_user) > 0)
                foreach ($conversations_with_user as $conv) {
                    $conv = DB::table('mc_conversations')
                        ->where('id', $conv)
                        ->first();

                    $data = json_decode($conv->data);

                    if ($data->adId == $ad->id) {
                        $conversation_id = $conv->id;
                    }
                }

            if ($conversation_id !== false) {
                $conversation = Chat::conversations()->getById($conversation_id);
            }
        }

        if ($conversation === null) {
            $conversation = Chat::createConversation([Auth::user()->id, $user_id]);

            $data = ['adId' => $ad->id];
            $conversation->update(['data' => $data]);
        }

        return response()->json(['status' => 'success', 'id' => $conversation->id, 'product_id' => $request->input('adId')]);
    }

    public function dialog_list(Request $request)
    {
        $my_conversations = DB::table('mc_conversation_user')
            ->where('user_id', Auth::user()->id)
            ->get();

        $Chats = [];

        if (count($my_conversations) > 0) {
            foreach ($my_conversations as $conv) {
                $conversation = Chat::conversations()->getById($conv->conversation_id);
                $users        = [];
                foreach ($conversation->users as $user) {
                    $users[] = $user->id;
                }

                $Ad = Ads::withTrashed()
                    ->where('id', $conversation->data['adId'])
                    ->first();

                $User = NULL;
                foreach ($users as $user)
                    if ($user != Auth::user()->id)
                        $User = DB::table('users')
                            ->where('id', $user)
                            ->first();

                $Messages                      = Chat::conversation(Chat::conversations()->getById($conversation->id))->for(Auth::user())->getMessages()->items();
                $Chats[$conv->conversation_id] = [
                    'Ad'       => $Ad,
                    'User'     => $User,
                    'Messages' => (array)$Messages
                ];
            }

        }

        return view('newthemplate/messages-list', ['Chats' => $Chats]);
    }

    public function dialog($id, Request $request)
    {
        $conversation = Chat::conversations()->getById($id);

        if ($conversation == NULL)
            return redirect('/');

        $users = [];
        foreach ($conversation->users as $user) {
            $users[] = $user->id;
        }

        if (!in_array(Auth::user()->id, $users))
            return redirect('/');

        $Ad = DB::table('ads')
            ->where('id', $conversation->data['adId'])
            ->first();

        foreach ($users as $user)
            if ($user != Auth::user()->id)
                $User = DB::table('users')
                    ->where('id', $user)
                    ->first();

        $Messages = Chat::conversation(Chat::conversations()->getById($conversation->id))->for(Auth::user())->getMessages()->items();

        return view('newthemplate/dialog', ["Chat" => $conversation, 'Messages' => $Messages, 'Ad' => $Ad, 'User' => $User]);
    }

    public function AddMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'chat_id' => 'required|integer',
            'message' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error']);
        }

        $conversation = Chat::conversations()->getById(intval($request->input('chat_id')));

        $type = 'text';
        $msg  = $request->input('message');

        $message = Chat::message($msg)
            ->type($type)
            ->from(Auth::user())
            ->to($conversation)
            ->send();

        $avatar = auth()->user()->avatar ?? '/mooimarkt/img/photo_camera.svg';
        $html   = '
			<div class="message-item your-message" data-id="' . $message->id . '">
				<label class="checkbox">
					<input type="checkbox">
					<span class="checkmark"></span>
				</label>
				<div class="message-wrap">
                    <div class="text-message" style="background-color: #FAE2D8;">
                        <p>' . $message->body . '</p>
                        <div style="color: #5f5f5f; font-size: 10px">
                            ' . date('H:i', strtotime($message->created_at)) . '
                        </div>
                    </div>
                </div>
				<div class="img-wrap">
					<img src="' . $avatar . '" alt="">
				</div>
			</div>
		';

        return response()->json(['status' => 'success', 'html' => $html]);
    }

    public function DeleteMessages(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'chat_id'  => 'required|integer',
            'messages' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(array('status' => 'error'));
        }

        if ($request->input('messages')) {
            foreach ($request->input('messages') as $message_id) {
                $message = Chat::messages()->getById($message_id);
                Chat::message($message)->setUser(auth()->user())->delete();
            }
        }

//		$participantModel->getParticipantDetails();

//		$message = Chat::messages()->getById(32);
//		Chat::message($message)->setParticipant(Auth::user()->id)->delete();
//		Chat::message($message)->setParticipant(Auth::user())->delete();
//		Chat::message($message)->setUser(auth()->user())->delete();

        /*
        $message = Chat::messages()->getById(32);
        $messageId = 32;
        $userId = Auth::user()->id;
//		Chat::trash($messageId, $userId);
//		Chat::message($message)->trash($messageId, $userId);
        Chat::message($message)->delete();
        */

//		$message = Chat::messages()->getById(32);
//		Chat::message($message)->setUser(Auth::user()->id)->delete();

        return response()->json(array('status' => 'success'));
        exit('ex');
    }

    public function MarkMessagesRead(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'messages' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error']);
        }

        if ($request->input('messages')) {
            foreach ($request->input('messages') as $message_id) {
                $message = Chat::messages()->getById($message_id);
                Chat::message($message)->setUser(auth()->user())->markRead();
            }
        }

        return response()->json(['status' => 'success', 'data' => [
            'read_messages_count' => count($request->messages ?? []),
        ]]);
    }

    public function DeleteChat(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'chat_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error']);
        }

        if ($request->input('chat_id')) {
            $chat = Chat::conversations()->getById($request->input('chat_id'));
            Chat::conversation($chat)->removeParticipants([auth()->user()]);
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * Save dialog attach file in message
     * @param Request $request [description]
     */
    public function AddFile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'chat_id' => 'required|integer',
            'file'    => 'required|file',
        ]);

        if ($validator->fails()) {
            return response()->json(array('status' => 'error'));
        }

        $conversation = Chat::conversations()->getById(intval($request->input('chat_id')));

        $type     = 'file';
        $file     = $request->file('file');
        $filename = md5(substr(str_replace(' ', '', microtime() . microtime()), 0, 40) . time()) . '.' . $file->getClientOriginalExtension();
        $path     = $file->storeAs(
            'attachment/' . str_random(2) . '/' . str_random(2),
            $filename,
            'public'
        );

        $msg     = '<a href="' . url('/storage/' . $path) . '" data-fancybox>' . $file->getClientOriginalName() . '</a>';
        $message = Chat::message($msg)
            ->type($type)
            ->from(Auth::user())
            ->to($conversation)
            ->send();

        $avatar = auth()->user()->avatar ?? '/mooimarkt/img/photo_camera.svg';
        $html   = '
			<div class="message-item your-message" data-id="' . $message->id . '">
				<label class="checkbox">
					<input type="checkbox">
					<span class="checkmark"></span>
				</label>
				<div class="message-wrap">
					<div class="text-message">
						<p>' . $message->body . '</p>
					</div>
					<div class="message-time">
						' . date('d.m.Y H:i', strtotime($message->created_at)) . '
					</div>
				</div>
				<div class="img-wrap">
					<img src="' . $avatar . '" alt="">
				</div>
			</div>
		';

        return response()->json(array('status' => 'success', 'html' => $html));
    }

    public function GetUnreadMessagesCount(Request $request)
    {
        if (Auth::check()) {
            $unreadCount = Chat::messages()->setUser(auth()->user())->unreadCount();

            return response()->json(array('status' => 'success', 'unread_count' => $unreadCount));
        }

        return response()->json(array('status' => 'error'));
    }

    public function GetMessages(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'chat_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(array('status' => 'error'));
        }

        $conversation = Chat::conversations()->getById(intval($request->input('chat_id')));
        $Messages     = Chat::conversation(Chat::conversations()->getById($conversation->id))->for(Auth::user())->getMessages()->items();
        $messages     = [];

        foreach ($Messages as $message) {
            if ($message->user_id != Auth::user()->id) {
                /*
                $messages[$message->id] = '
                    <div class="user-1 message_box" data-id="'.$message->id.'">
                        <p class="today">today<a class="border-a">at '.date('H:i', strtotime($message->created_at)).'</a></p>
                        <p class="user-messang-1"><span>'.$message->body.'</span></p>
                    </div>
                ';
                */
                $user                   = User::find($message->user_id);
                $avatar                 = $user->avatar ?? '/mooimarkt/img/photo_camera.svg';
                $messages[$message->id] = '
					<div class="message-item person-message ' . (!$message->read_at ? 'unread' : '') . '" data-id="' . $message->id . '">
						<label class="checkbox">
							<input type="checkbox">
							<span class="checkmark"></span>
						</label>
						<div class="img-wrap">
							<img src="' . $avatar . '" alt="">
						</div>
						<div class="message-wrap">
                        <div class="text-message" style="background-color: white;">
                            <p>' . $message->body . '</p>
                            <div style="color: #5f5f5f; font-size: 10px">
                                ' . date('H:i', strtotime($message->created_at)) . '
                            </div>
                        </div>
                    </div>
					</div>
				';
            }
        }

        $updated_at = DB::table('mc_conversation_user')
            ->where([
                ['user_id', '<>', Auth::user()->id],
                ['conversation_id', $request->input('chat_id')]
            ])
            ->first()
            ->updated_at;

        $is_typing = (strtotime("now") - strtotime($updated_at)) < 3 ? true : false;

        $unreadCount = Chat::messages()->setUser(auth()->user())->unreadCount();

        return response()->json(array('status' => 'success', 'messages' => $messages, 'is_typing' => $is_typing, 'unread_count' => $unreadCount));

    }

    /**
     * Update last typing if user typing in conversation
     * @param Request $request [description]
     * @return [type]           [description]
     */
    public function typing(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'chat_id' => 'required|integer',
        ]);
        $is_typing = DB::table('mc_conversation_user')
            ->where([
                ['user_id', Auth::user()->id],
                ['conversation_id', $request->input('chat_id')]
            ])
            ->update(['updated_at' => new \DateTime()]);
    }

    public function messages(Request $request)
    {
        $totalGems        = auth()->user()->Ads->where('adsStatus', 'payed')->sum('adsPrice');
        $my_conversations = DB::table('mc_conversation_user')->where('user_id', auth()->user()->id)->latest()->get();

        $countMessageSelling = 0;
        $countMessageBuying  = 0;
        $Products            = [];

        foreach ($my_conversations as $conv) {
            $conversation = Chat::conversations()->getById($conv->conversation_id);

            if ($conversation->users->count() === 1) {
                continue;
            }

            $users = [];
            foreach ($conversation->users as $user) {
                $users[] = $user->id;
            }

            $Ad = Ads::withTrashed()
                ->where('id', $conversation->data['adId'])
                ->with('images')
                ->first();

            if (!empty($Ad)) {
                foreach ($users as $user) {
                    if ($user != auth()->user()->id) {
                        $User = User::find($user);
                    }
                }

                $message             = Chat::conversation(Chat::conversations()->getById($conversation->id))->for(auth()->user());
                $messages            = $message->getMessages()->items();
                $messagesUnreadCount = $message->unreadCount();

                if ($Ad->userId == Auth::id()) {
                    $countMessageSelling += $messagesUnreadCount;
                } else {
                    $countMessageBuying += $messagesUnreadCount;
                }

                $Products[$Ad->id]['Product']                       = $Ad;
                if (isset($Products[$Ad->id]['messages_unread_count'])) {
                    $Products[$Ad->id]['messages_unread_count'] += $messagesUnreadCount;
                } else {
                    $Products[$Ad->id]['messages_unread_count'] = $messagesUnreadCount;
                }
                $Products[$Ad->id]['Chats'][$conv->conversation_id] = [
                    'Ad'       => $Ad,
                    'User'     => $User ?? null,
                    'Messages' => (array)$messages
                ];
            }
        }

        return view('site.profile.messages', compact('Products', 'totalGems', 'countMessageSelling', 'countMessageBuying'));
    }
}