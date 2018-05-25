<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DialogParticipant extends Model
{
    protected $fillable = [
      'dialog_id', 'user_id'
    ];
}
