<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'price','finish_date','figure_id','shop_id',
    ];


    public function figure() {
        return $this->belongsTo('App\Figure');
  }

    public function shop() {
        return $this->belongsTo('App\Shop');
  }

  public function figures(){
      return $this->belongsToMany('App\Figure');
  }

}
