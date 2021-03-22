<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inbox extends Model
{
    use SoftDeletes;
    
    protected $table = 'inbox';
    protected $primaryKey = 'id';

    public function getMessage() {
        return $this->hasMany('App\User', 'userId');
    }

    public function getAds() {
        return $this->hasOne('App\Ads', 'id',"adsId");
    }

    public function getSender(){
        return $this->belongsTo('App\User', 'userId');
    }

    public function getReceiver(){
        return $this->hasOne('App\User', 'id', "toID");
    }
    public function getLastMsg() {
        return \DB::table("chats")->where("inboxId",$this->id)
                    ->whereNull("deleted_at")
                    ->orderBy("created_at","desc")
                    ->first();
    }
    public function getUnreadMsgCount() {
        return $this->hasMany('App\Chat', 'inboxId',"id")->where("seen","=","0")->count();
    }
}
