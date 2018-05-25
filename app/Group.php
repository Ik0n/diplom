<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
      'name', 'avatar', 'creator'
    ];

    public function getMessages() {
        $messages = $this->hasMany(Message::class, 'recipient_id', 'id');

        return $messages->where('recipient_type', '=', 'App\Group')->orderBy('CREATED_AT', 'DESC');
    }

    public function getUsers() {
        $user = $this->belongsToMany(
            User::class,
            'group_participants'
        );

        return $user;
    }
}
