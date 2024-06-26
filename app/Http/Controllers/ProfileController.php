<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{
    private $user;

    public function __construct(User $user){
        $this->user = $user;
    }

    /**
     * Search for the user details
     */
    public function show($id){
        
        $user = $this->user->findOrFail($id);

        return view('users.profile.show')->with('user', $user);
    }

    /**
     * This method is use to open the edit profile page (edit.blade.php)
     */
    public function edit(){
        $user = $this->user->findOrFail(Auth::user()->id);
        return view('users.profile.edit')->with('user', $user);
    }

    /**
     * This method is use to perform the actual update
     */
    public function update(Request $request){
        # Validate the data
        $request->validate([
            'name' => 'required|min:1|max:50',
            'email' => 'required|email|max:50|unique:users,email,' . Auth::user()->id,
            'avatar' => 'mimes:jpeg,jpg,gif,png|max:1048',
            'introduction' => 'max: 100'
        ]);

        # Update the data
        $user = $this->user->findOrFail(Auth::user()->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->introduction = $request->introduction;

        if ($request->avatar) {
            $user->avatar = 'data:image/' . $request->avatar->extension() . ';base64,' . base64_encode(file_get_contents($request->avatar));
        }

        # Save
        $user->save();

        # Redirect
        return redirect()->route('profile.show', Auth::user()->id);


    }

    /**
     * This method is use to get the details of the follower
     */
    public function followers($id){
        $user = $this->user->findOrFail($id); //The $id is the ID of the user we want to see
        return view('users.profile.followers')->with('user', $user);
    }

    /**
     * This method is use to get the details of the users being followed by the AUTH USER
     */
    public function following($id){
        $user = $this->user->findOrFail($id);
        return view('users.profile.following')->with('user', $user);
    }



}
