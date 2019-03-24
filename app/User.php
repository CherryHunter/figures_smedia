<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Friend;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'permission_id', 'description', 'avatar', 'reported', 'banned'
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

  public function actual_notifications(){
      return $this->hasMany('App\ActualNotification');
  }

  public function friends(){
      $friends = [];
      if (count($friends1 = Friend::where('user1_id', $this->id)->where('accepted','1')->get())!=0){
      foreach ($friends1 as $user){
      array_push($friends,$user->receiver);
      }}
      if (count($friends2 = Friend::where('user2_id', $this->id)->where('accepted','1')->get())!=0){
      foreach ($friends2 as $user){
      array_push($friends,$user->sender);
      }}
      return $friends;
  }

  public function allnotifications(){
    $all_notifications = 0;
    if (count($notifications = ActualNotification::where('user_id', $this->id)->get())!=0){
    $all_notifications = $all_notifications + count($notifications);}
    if (count($requests = Friend::where('user2_id', $this->id)->where('accepted','0')->get())!=0){
    $all_notifications = $all_notifications + count($requests);}
    return $all_notifications;
  }


  public function myfigures(){
      return $this->hasMany('App\Collection');
  }

  public function reports(){
      return $this->hasMany('App\Report');
  }


}
