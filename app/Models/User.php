<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    const ADMIN_ROLE_ID = 1; //Admin User
    const USER_ROLE_ID = 2; // Regular user

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Use this method to get all the posts of a user
     */
    public function posts(){
        return $this->hasMany(Post::class)->latest();
    }

    /**
     * Use this method to get all the followers of a user
     */
    public function followers(){
        return $this->hasMany(Follow::class, 'following_id');
        # Note: To get all the followers, we can select the following_id column
        # from the follow model
    }

    /**
     * Use this method to get all the users the the AUTH USER is following
     */
    public function following(){
        return $this->hasMany(Follow::class, 'follower_id');
    }

    /**
     *  Use this method to check if the AUTH USER ( logged-in user ) is already following the user
     */
    public function isFollowed(){ //True or False
        return $this->followers()->where('follower_id', Auth::user()->id)->exists();
        # Auth::user()->id --- the follower id
        # Firstly, get all the followers of the user ( $this->followers() ). Then, from that lists, we search for the AUTH USER ID from the follower colum ( 'follower_id', Auth::user()->id ) if that exists
    }

}
