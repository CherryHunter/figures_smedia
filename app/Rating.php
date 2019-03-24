<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
protected $fillable = array( 'user_id', 'figure_id');

public $timestamps = false;

public function user() {
    return $this->belongsTo('App\User');
}
}
