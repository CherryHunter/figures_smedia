<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Figure extends Model
{
    protected $fillable = [
        'character', 'series', 'producer', 'popularity', 'photo',
    ];

    public function sales(){
        return $this->hasMany('App\Sale');
    }

    public function notfifiedUsers(){
        return $this->belongsToMany('App\User');
    }

    public function characters(){
        return $this->belongsToMany('App\Character');
      }
    /*public function sales(){
        return $this->belongsToMany('App\Sale');
    }
    */
}
