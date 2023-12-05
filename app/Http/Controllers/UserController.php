<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    // public function profileUpdate(Request $request, $id)
    // {
    //     $user = User::findOrFail($id);

    //     // Check if the authenticated user has the "user" role
    //     if (auth()->user()->hasRole('user')) {
    //         // Ensure that the authenticated user is trying to update their own profile
    //         if (auth()->user()->id === $user->id) {
    //             $data = $request->all();
    //             $status = $user->update($data);

    //             if ($status) {
    //                 return response()->json(['message' => 'Successfully updated your profile']);
    //             } else {
    //                 return response()->json(['error' => 'Please try again'], 500);
    //             }
    //         } else {
    //             return response()->json(['error' => 'Unauthorized to update this profile'], 403);
    //         }
    //     } else {
    //         return response()->json(['error' => 'Unauthorized to update profiles'], 403);
    //     }
    // }

    public function deposit ()
    {

    }

    public function withdrawal ()
    {

    }

    
}
