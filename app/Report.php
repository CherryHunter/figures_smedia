<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
  protected $fillable = [
      'body', 'user_id', 'created_at', 'updated_at'
  ];

  public function user() {
      return $this->belongsTo('App\User');
}
}
