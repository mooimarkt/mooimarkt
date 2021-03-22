<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RatingUser extends Model
{

    protected $table = 'rating_user';
    protected $primaryKey = 'id';

    public static function countLike($user_id) {
    	return \DB::table("rating_user")
            ->where("user_id", $user_id)
            ->where('event', 'like')
            ->count();
    }

    public static function countDislike($user_id) {
    	return \DB::table("rating_user")
            ->where("user_id", $user_id)
            ->where('event', 'dislike')
            ->count();
    }

}
