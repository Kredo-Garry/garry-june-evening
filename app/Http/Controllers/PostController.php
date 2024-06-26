<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Category; //represents the categories table
use App\Models\Post;     //represents the posts table

class PostController extends Controller
{
    private $post;
    private $category;

    public function __construct(Category $category, Post $post){
        $this->post = $post;
        $this->category = $category;
    }

    public function create(){

        $all_categories = $this->category->all(); //SELECT * FROM categories;

        return view('users.posts.create')->with('all_categories', $all_categories);
    }

    public function store(Request $request){
        # 1. Validate the data first
        $request->validate([
            'category' => 'required|array|between:1,3',
            'description' => 'required|min:1|max:1000',
            'image' => 'required|mimes:jpeg,jpg,png,gif|max:1048'
        ]);

        # 2. Save the post details into the database posts table
        $this->post->user_id = Auth::user()->id; //owner of the post
        $this->post->image = 'data:image/'. $request->image->extension() . ';base64,' . base64_encode(file_get_contents($request->image));
        $this->post->description = $request->description;
        $this->post->save(); //post id 1


        # 3. Save the categories
        foreach ($request->category as $category_id) {
            $category_post[] = ['category_id' => $category_id];

            # Example:
            # $category_post[2, 5, 6]


        }
        $this->post->categoryPost()->createMany($category_post);

        # 4. Go back to the homepage
        return redirect()->route('index');
    }

    /**
     * Open up show post page
     *  The "$id" is the ID of the post we want to open
     */
    public function show($id){

        $post = $this->post->findOrFail($id);
        //Same as: SELECT * FROM posts WHERE id = $id;

        return view('users.posts.show')->with('post', $post);
    }

    /**
     * This method is going to search for the post that we will going to edit
     */
    public function edit($id){

        # first data
        $post = $this->post->findOrFail($id); //remember: the $id is the id of the post we want to edit/update
        //Same as: SELECT * FROM posts WHERE id = $id;

        
        # If the AUTH user is not the owner of the post, redirect the user to the homepage
        if (Auth::user()->id != $post->user->id) {
            return redirect()->rout('index');
        }

        # second data
        # Search and get all the categories from the categories table
        $all_categories = $this->category->all();
        //Same as: SELECT * FROM categories;

        # Get all the category IDs of this post, and save it in an array
        $selected_categories = [];

        # Example: post id 7 --> 3,4,5
        foreach ($post->categoryPost as $category_post) {
            # third data
            $selected_categories[] = $category_post->category_id;

            # Example:
            # $selected_categories[3,4,5]

        }

        return view('users.posts.edit')
            ->with('post', $post)
            ->with('all_categories', $all_categories)
            ->with('selected_categories', $selected_categories);
    }

    /**
     * This method is going to perform the actual update
     */
    public function update(Request $request, $id){
        # 1. Validate the data first
        $request->validate([
            'category' => 'required|array|between:1,3',
            'description' => 'required|min:1|max:1000',
            'image' => 'mimes:jpeg,jpg,png,gif|max:1048'
        ]);

        # 2. Update the post
        $post = $this->post->findOrFail($id);
        $post->description = $request->description;

        # 3. Check for new uploaded image
        if ($request->image) {
            $post->image = 'data:image/' . $request->image->extension() . ';base64,' . base64_encode(file_get_contents($request->image)); 
        }
        $post->save(); //Same as: UPDATE posts SET description = '$request->description', image = '$request->image' WHERE id = $id;


        # 4. Delete all records from category_post table related to this post
        $post->categoryPost()->delete();
        //Use the relationship Post::categoryPost() to select the records related to the post
        // Same as: DELETE FROM category_post WHERE post_id = $id

        # 5. Save the new categories into the category_post table
        foreach ($request->category as $category_id) {
            $category_post[] = ['category_id' => $category_id];
        }
        $post->categoryPost()->createMany($category_post);

        # 6. Redirect to show post page (to confirm the update)
        return redirect()->route('post.show', $id);
    }

    /**
     * This method is use to delete a post
     */
    public function destroy($id){
        $post = $this->post->findOrFail($id);
        $post->forceDelete(); //delete entirely
        return redirect()->route('index');
    }
}
