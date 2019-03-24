<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{

    protected $fillable = [
        'user_id', 'character_id',
    ];

    public $timestamps = false;

    public function user() {
        return $this->belongsTo('App\User');
  }

  public function character() {
      return $this->belongsTo('App\Character');
}
}
