<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dialog extends Model
{
    protected $fillable = [
      'name', 'avatar'
    ];

    public function getMessages() {
        $messages = $this->hasMany(Message::class, 'recipient_id', 'id');

        return $messages->where('recipient_type', '=', 'App\Dialog');
    }


    public function participants() {
        return $this->hasMany(DialogParticipant::class);
    }
}
