<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'permission_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function comments(){
        return $this->hasMany('App\Comment');
    }

    public function sales(){
        return $this->hasMany('App\Sale');
    }

    public function receivedMails(){
        return $this->hasMany('App\Malibox', 'receiver_id','id');
    }

    public function sentMails(){
        return $this->hasMany('App\Malibox', 'sender_id','id');
    }

    public function notifications(){
        return $this->hasMany('App\Notification');
    }

    public function salePosts(){
        return $this->hasMany('App\SalePost');
    }


    public function permission() {
        return $this->belongsTo('App\Permission');
  }

  public function notfifications(){
      return $this->belongsToMany('App\Figure');
  }


}
