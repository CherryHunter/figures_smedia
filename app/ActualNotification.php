<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActualNotification extends Model
{
  protected $fillable = [
      'user_id', 'sale_id',
  ];

  public $timestamps = false;

  public function user() {
      return $this->belongsTo('App\User');
}

public function sale() {
    return $this->belongsTo('App\Sale');
}

}
