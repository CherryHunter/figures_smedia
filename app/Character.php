<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Character extends Model
{

  protected $fillable = [
      'name',
  ];

  public function figures(){
      return $this->hasMany('App\Figure');
  }
}
