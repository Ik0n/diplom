<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    public function groups() {
            return $this->belongsToMany(
                Group::class,
                'group_participants'
            );
    }

    public function dialogs() {
        return $this->belongsToMany(
            Dialog::class,
            'dialog_participants'
        );
    }

    public function photoAlbum() {
        $photoAlbum = $this->hasMany(Album::class);

        return $photoAlbum->where('type', '=', 'photo');
    }

    public function videoAlbum() {
        $videoAlbum = $this->hasMany(Album::class);

        return $videoAlbum->where('type', '=', 'video');
    }

    public function inboxFriends() {
        $inboxFriends = $this->belongsToMany(User::class, 'friends', 'user_id1', 'user_id2');

        return $inboxFriends->where('friends', '=', '1');
    }

    public function outboxFriends() {
        $outboxFriends = $this->belongsToMany(User::class, 'friends', 'user_id2', 'user_id1');

        return $outboxFriends->where('friends', '=', '1');
    }

    //public function friends() {
    //    $test = $this->belongsToMany(User::class, 'friends');
    //
    //    return $test->where('friends','=','1');
    //}

    public function inboxRequestFriends() {
        $inboxFriends = $this->belongsToMany(User::class, 'friends', 'user_id2', 'user_id1');

        return $inboxFriends->where('friendsRequest', '=', '1');
    }

    public function outboxRequestFriends() {
        $inboxFriends = $this->belongsToMany(User::class, 'friends', 'user_id1', 'user_id2');

        return $inboxFriends->where('friendsRequest', '=', '1');
    }


    public function myReceivedMessages() {
        $messages = $this->hasMany(Message::class, 'recipient_id');
        return $messages->where('recipient_type', '=', 'App\User');
    }

    public function mySentMessages() {
        return $this->hasMany(Message::class, 'user_id_sender');
    }

    public function messages() {
        return $this->hasMany(Message::class);
    }

    public function myReceivedImages() {
        return $this->hasMany(Image::class, 'user_id_recipient');
    }

    public function mySentImages()  {
        return $this->hasMany(Image::class, 'user_id_sender');
    }

    public function likes() {
        return $this->belongsToMany(Message::class, 'likes', 'user_id','post_id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'password', 'email', 'number', 'first_name', 'last_name', 'third_name', 'country', 'city', 'filename', 'admin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getRouteKeyName()
    {
        return 'name'; // TODO: Change the autogenerated stub
    }
}