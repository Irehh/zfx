<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    
    public function showProfile(Request $request)
    {
        
                // Retrieve the authenticated user
                $user = auth()->user();

                if ($user) {
                    // Load relationships
                    $user->load('UserDetails');
        
                    // You can customize the data you want to return in the response
                    $data = [
                        'user' => $user,
                        'user_detail' => $user->UserDetail,
                    ];
        
                    return response()->json(['status' => 'success', 'data' => $data], 200);
                } else {
                    return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
                }
        
    }

    public function updateProfile(Request $request, $slug)
    {
        // Find the user with the UserDetails relationship loaded
        $user = User::with('UserDetails')->where('slug', $slug)->firstOrFail();

        // Validate the request data
        $request->validate([
            'details_data' => 'array', // Data for UserDetails model
            'details_data.last_name' => 'sometimes|string',
            'details_data.first_name' => 'sometimes|string',
            'details_data.city' => 'sometimes|string',
            'details_data.country' => 'sometimes|string',
            'details_data.photo' => 'sometimes|string',
            'details_data.verification_document' => 'sometimes|string',
            'details_data.profile_image' => 'sometimes|string',
            'details_data.phone_number' => 'sometimes|string',
        ]);

        // Get the original user data before the update
        $originalUserData = $user->UserDetails ? $user->UserDetails->getAttributes() : [];

        // Update or create UserDetails
        $user->UserDetails()->updateOrCreate([], [
            'last_name' => $request->input('details_data.last_name', ''),
            'first_name' => $request->input('details_data.first_name', ''),
            'city' => $request->input('details_data.city', ''),
            'country' => $request->input('details_data.country', ''),
            'photo' => $request->input('details_data.photo', ''),
            'verification_document' => $request->input('details_data.verification_document', ''),
            'profile_image' => $request->input('details_data.profile_image', ''),
            'phone_number' => $request->input('details_data.phone_number', ''),
            'photo' => $request->input('details_data.photo', ''),
        ]);

        // Reload the user with the UserDetails relationship
        $user = $user->fresh();

        // Get the updated user data
        $updatedUserData = $user->UserDetails ? $user->UserDetails->getAttributes() : [];

        // Check if any attributes were changed
        $userUpdated = $originalUserData != $updatedUserData;

        // Return a JSON response
        if ($userUpdated) {
            return response()->json(['message' => 'User updated successfully', 'data' => $user], 200);
        } else {
            return response()->json(['message' => 'No changes were made to the user.'], 200);
        }
    }

}
