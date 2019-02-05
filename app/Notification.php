<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{

    protected $fillable = [
        'user_id', 'figure_id',
    ];

    public function user() {
        return $this->belongsTo('App\User');
  }

  public function figure() {
      return $this->belongsTo('App\Figure');
}
}
