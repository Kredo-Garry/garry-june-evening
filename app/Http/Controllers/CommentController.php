<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Comment; // represents the comments table

class CommentController extends Controller
{
    private $comment;

    public function __construct(Comment $comment){
        $this->comment = $comment;
    }

    public function store(Request $request, $post_id){
        # 1. Validate
        $request->validate(
            [
                'comment_body' . $post_id => 'required|max:150'
            ],
            [
                'comment_body' . $post_id . '.required' => 'You cannot submit an empty comment.',
                'comment_body' . $post_id . '.max' => 'The comment must not have more than 150 characters.'
            ]
    );

        $this->comment->body = $request->input('comment_body' . $post_id); //the actual comment
        $this->comment->user_id = Auth::user()->id; // owner of the comment
        $this->comment->post_id = $post_id; //the id of the being commented on
        $this->comment->save();

        return redirect()->back();
    }

    public function destroy($id){
        $this->comment->destroy($id);
        return redirect()->back();
    }
}
