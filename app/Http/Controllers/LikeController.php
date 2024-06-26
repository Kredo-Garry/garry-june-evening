<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Like; # represents the likes table

class LikeController extends Controller
{
    private $like;

    public function __construct(Like $like){
        $this->like = $like;
    }

    /**
     * This method is use to store the like action into likes table
     */
    public function store($post_id){ # The $post_id is the id of the post being liked

        $this->like->user_id = Auth::user()->id; // the owner of the liked
        $this->like->post_id = $post_id;         // the id of the post being liked
        $this->like->save();
        # Same as: "INSERT INTO likes(user_id, post_id) VALUES('Auth::user()->id', '$post_id')";

        return redirect()->back();
    }

    /**
     * Destroy/Unlike
     */
    public function destroy($post_id){
        $this->like
            ->where('user_id', Auth::user()->id) //owner of the liked
            ->where('post_id', $post_id)         //the post id being liked
            ->delete();


        # Same as: DELETE FROM likes WHERE user_id = Auth::user()->id && post_id = $post_id;

        return redirect()->back();
    }

}
