<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['content','user_id','message_id'];

    public function message() {
        return $this->belongsTo(Message::class);
    }

    public  function whoSend() {
        return $this->hasOne(User::class, 'id','user_id');
    }
}
