<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'body', 'user_id', 'figure_id', 'created_at', 'updated_at', 'reported'
    ];

    public function user() {
        return $this->belongsTo('App\User');
  }

  public function sale() {
      return $this->belongsTo('App\Sale');

    }

  public function figure() {
    return $this->belongsTo('App\Figure');
  }

}
