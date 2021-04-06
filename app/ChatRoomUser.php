<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatRoomUser extends Model
{
    protected $fillable = ['chat_room_id','user_id'];//値が代入できるフィールドを用意しておく

    public function chatRoom()
    {
        return $this->belongsTo('App\ChatRoom');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }


}
