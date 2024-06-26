<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; // this represents the users table

class UsersController extends Controller
{
    private $user;

    public function __construct(User $user){
        $this->user = $user;
    }

    public function index(){
        # Retrieve all the users from users table
        $all_users = $this->user->withTrashed()->latest()->paginate(5); //5 users per page
        // SELECT * FROM users ORDER BY DESC LIMIT 5;
        return view('admin.users.index')->with('all_users', $all_users);
        # Note: The " withTrashed() " will include the soft deleted users in the query result
    }

    /**
     * Method to deactivate users
     */
    public function deactivate($id){
        $this->user->destroy($id);
        return redirect()->back();
    }

    /**
     * Method to activate users
     */
    public function activate($id){
        $this->user->onlyTrashed()->findOrFail($id)->restore();
        return redirect()->back();
        // The " onlyTrashed() " retrieves the soft deleted users
        // The " restore() " will "un-delete" a soft deleted user in the "deleted_at" column
    }
}
