<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['content','recipient_id', 'recipient_type','user_id_sender', 'author','filename', 'private'];

    public function whoAuthor() {
        return $this->hasOne(User::class,'id','author');
    }

    public  function whoSend() {
        return $this->hasOne(User::class, 'id', 'user_id_sender');
    }

    public function tags() {
        return $this->belongsToMany(Tag::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function comments() {
        return $this->belongsTo(Comment::class);
    }

    public function getComments() {
        return $this->hasMany(Comment::class);
    }

    public function likes_for_messages() {
        return $this->belongsTo(User::class, 'likes_for_message');
    }

    public function likes_for_comments() {
        return $this->belongsToMany(User::class, 'likes_for_comment');
    }

}