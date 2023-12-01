<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Apiusers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{

    public function profileUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Check if the authenticated user has the "user" role
        if (auth()->user()->hasRole('user')) {
            // Ensure that the authenticated user is trying to update their own profile
            if (auth()->user()->id === $user->id) {
                $data = $request->all();
                $status = $user->update($data);

                if ($status) {
                    return response()->json(['message' => 'Successfully updated your profile']);
                } else {
                    return response()->json(['error' => 'Please try again'], 500);
                }
            } else {
                return response()->json(['error' => 'Unauthorized to update this profile'], 403);
            }
        } else {
            return response()->json(['error' => 'Unauthorized to update profiles'], 403);
        }
    }

    public function deposit ()
    {

    }

    public function withdrawal ()
    {

    }

    public function profile()
    {
        // Retrieve the authenticated user
        $user = auth()->user();

        if ($user) {
            // Load relationships
            $user->load('userDetail', 'userWallet');

            // You can customize the data you want to return in the response
            $data = [
                'user' => $user,
                'user_detail' => $user->userDetail,
                'user_wallet' => $user->userWallet,
            ];

            return response()->json(['status' => 'success', 'data' => $data], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }
    }


}
