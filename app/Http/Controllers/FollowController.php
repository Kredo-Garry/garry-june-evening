<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Follow; // this represents the follows table

class FollowController extends Controller
{
    private $follow;

    public function __construct(Follow $follow){
        $this->follow = $follow;
    }

    /**
     *  This method is use to store/insert the ID of the FOLLOWER, and the ID of the USER being followed
     *  into the follows table
     */
    public function store($user_id){

        $this->follow->follower_id = Auth::user()->id; // the id of the follower
        $this->follow->following_id = $user_id;        // the id of the user being followed
        $this->follow->save();
        # Same as: "INSERT INTO follows(follower_id, following_id) VALUES('Auth::user()->id', '$user_id')";

        return redirect()->back();
    }

    /**
     * Destroy/Unfollow
     */
    public function destroy($user_id){
        $this->follow
            ->where('follower_id', Auth::user()->id) //the follower id to delete
            ->where('following_id', $user_id)        //the user being followed -- to delete
            ->delete();

        return redirect()->back();
    }
}
