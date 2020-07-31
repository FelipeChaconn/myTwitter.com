<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Tweet;
class User extends Authenticatable
{
    use Notifiable;
    use Notifiable, Followable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function timeline() {
        //include all of the users tweets;
        //as well as the tweets of everyone they follow in desending order by date.
    //     $friends = $this->follows()->pluck('id');

    //    return Tweet::whereIn('user_id',$friends)->orWhere('user_id',$this->id)->latest()->get();
    return Tweet::where('user_id',$this->id)
    ->latest()
    ->get();
    }


    public function tweets() {
        return $this->hasMany(Tweet::class);
    }

    public function getAvatarAttribute() {
        return "https://i.pravatar.cc/200?u=". $this->email;
    }

    public function path()
    {
        return route('profile', $this->name);
    }

}
