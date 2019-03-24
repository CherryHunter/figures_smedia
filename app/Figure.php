<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Collection;
use App\Figure;
use App\Notifications;

class Figure extends Model
{
    protected $fillable = [
        'character', 'series', 'producer', 'popularity', 'photo',
    ];

    public $timestamps = false;

    public function sales(){
        return $this->hasMany('App\Sale');
    }



    public function character(){
        return $this->belongsTo('App\Character');
      }

    public function comments(){
      return $this->hasMany('App\Comment');
    }


   public function collection(){
     $collection = Collection::where('user_id', auth()->user()->id)->where('figure_id',$this->id)->first();
     return $collection;
    }

    public function notification(){
      $notification = Notification::where('user_id', auth()->user()->id)->where('character_id',$this->character->id)->first();
      return $notification;
     }

     public static function top3(){
       $top3 = Figure::orderBy('popularity','desc')->take(3)->get();
       return $top3;
     }

}
