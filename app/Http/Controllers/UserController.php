<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function profile()
    {
        //Retrieve the authenticated user
        $user = auth::user();  
        if ($user) {
            $userInfo = User::getUserInfo()->find($user->id);
            
            return response()->json(['status' => 'success', 'user' => $userInfo], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }
    }

    
    public function profileUpdate(Request $request)
    {
        
        $user = auth::user();  
        $userinfo = User::getUserInfo()->find($user->id);

        // Check if the authenticated user has the "user" role
        if (auth()->user()->role == 'user') {
            // Ensure that the authenticated user is trying to update their own profile
                $data = $request->all();
                $status = $user->update($data);

                if ($status) {
                    return response()->json([
                        'message' => 'Successfully updated your profile',
                        'userinfo' => $userinfo
                ]);
                } else {
                    return response()->json(['error' => 'Please try again'], 500);
                }
        } else {
            return response()->json(['error' => 'Unauthorized to update profiles'], 403);
        }
    }
}
