<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;
use DB;
use Auth;
use App\User;

class User extends Authenticatable
{
    use Notifiable;

    protected $userImagePath = 'img/users/';

    protected $userCoverPath = 'img/users/cover/';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'pivot'
    ];

    

    public function getFullName(){
        return $this->name;
    }

    public function updateOnlineStatus(){
        $now = Carbon::now();
        if ($this->online()->count()){
            // update
            $this->online()->update([
                'last' => $now
            ]);
        } else {
            // create
            $this->online()->create([
                'last' => $now
            ]);
        }
    }

    public function isOnline(){
        $now = Carbon::now()->subMinutes(2);
        if ($online = $this->online()->whereUserId($this->id)->first()){
            if ($online->last > $now){
                // online
                return true;
            } else {
                // offline
                return false;
            }
        }
    }


    /* Relations */

    public function friendsOfMine(){
        return $this->belongsToMany('App\User', 'friends', 'user_id', 'friend_id');
    }

    public function friendOf(){
        return $this->belongsToMany('App\User', 'friends', 'friend_id', 'user_id');
    }

    public function friends(){
        return $this->friendsOfMine()->wherePivot('accepted', true)->get()
        ->merge($this->friendOf()->wherePivot('accepted', true)->get());
    }

    public function friendRequests(){
        return $this->friendsOfMine()->wherePivot('accepted', false)->get();
    }

    public function friendRequestsPending(){
        return $this->friendOf()->wherePivot('accepted', false)->get();
    }

    public function hasFriendRequestPending(User $user){
        return (bool) $this->friendRequestsPending()->where('id', $user->id)->count();
    }

    public function hasFriendRequestPendingFrom(User $user){
        return (bool) $this->friendRequests()->where('id', $user->id)->count();
    }

    public function HasAnyFriendRequestsPending(){
        return $this->friendsOfMine()->wherePivot('user_id', Auth::user()->id)->where('accepted', 0)->get();
    }

    public function addFriend(User $user){
        return $this->friendOf()->attach($user->id);
    }

    public function removeFriend(User $user){
        return $this->friendOf()->detach($user->id);
    }

    public function acceptFriend(User $user){
        return (bool) $this->friendRequests()->where('id', $user->id)->first()->pivot->update([
                'accepted' => true
            ]);
    }

    public function isFriendsWith(User $user){
        return (bool) $this->friends()->where('id', $user->id)->count();
    }


}
