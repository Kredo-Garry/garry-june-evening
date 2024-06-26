<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class PostsController extends Controller
{
    private $post;

    public function __construct(Post $post){
        $this->post = $post;
    }

    public function index(){

        $all_posts = $this->post->withTrashed()->latest()->paginate(7);
        return view('admin.posts.index')->with('all_posts', $all_posts);
        # SELECT * FROM posts ORDER BY CREATED_AT DESC;
    }

    /**
     * This method hides the post (soft delete it)
     */
    public function hide($id){
        $this->post->destroy($id);
        return redirect()->back();
    }

    /**
     * This method unhide the post that have been soft deleted
     */
    public function unhide($id){
        $this->post->onlyTrashed()->findOrFail($id)->restore();
        return redirect()->back();
    }
}
