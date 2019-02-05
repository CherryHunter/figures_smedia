<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $fillable = [
        'name','link',
    ];

    public function sales(){
        return $this->hasMany('App\Sale');
    }
}
