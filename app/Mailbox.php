<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mailbox extends Model
{
    protected $fillable = [
        'body', 'sender_id', 'receiver_id',
    ];

    public function sender() {
        return $this->belongsTo('App\User');
  }

  public function receiver() {
      return $this->belongsTo('App\User');
}

}
