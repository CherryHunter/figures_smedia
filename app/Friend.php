<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{

  protected $fillable = [
      'user1_id', 'user2_id', 'accepted'
  ];

  public $timestamps = false;

  public function sender()
   {
   return $this->belongsTo('App\User', 'user1_id');
   }

   public function receiver()
    {
    return $this->belongsTo('App\User', 'user2_id');
    }

}
