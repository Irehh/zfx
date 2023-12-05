<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Apiusers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{

    public function apiregister (Request $request)
    {
        $fields =$request->validate(
            [
                'name' => 'required|string',
                'email' => 'required|string|unique:users,email',
                'password' => 'required|string|confirmed',
            ]);

            $user = Apiusers::create(
                [
                    'name' => $fields['name'],
                    'email' => $fields['email'],
                    'password' => bcrypt($fields['password'])
                ]);

        $token = $user->createToken('myapptoken')->plainTextToken;
        $response = 
        [
            'user' =>$user,
            'token' =>$token
        ];

         return response($response, 201);
    }

    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string|min:2',
            'email' => 'required|string|unique:users,email',
            'referrer' => 'string',
            'password' => 'required|string|confirmed|min:6',
        ]);

        // Generate a unique slug based on the user's name
        $slug = Str::slug($fields['name']);

        // Ensure slug uniqueness
        $count = User::where('slug', $slug)->count();
        if ($count > 0) {
        $slug = $slug . '-' . ($count + 1); // Append a number to make it unique
        }

        // Generate a unique referral code
        do {
            $uuid = (string) Str::uuid();
            $referralCode = substr($uuid, 0, 6);
        } while (User::where('referral_code', $referralCode)->exists());

        $fields['referral_code'] = $referralCode;
        // Create the user
        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'referrer' => $fields['referrer'],
            'password' => Hash::make($fields['password']),
            'status' => 'active',
            'slug' => $slug,
            'referral_code' => $fields['referral_code'],
        ]);
        $token = $user->createToken('myapptoken')->plainTextToken;

        // Return a JSON response
        if ($user) {
            $response = [
                'success' => 'Successfully registered',
                'user' => $user,
            ];
        } else {
            $response = [
                'error' => 'Please try again!',
            ];
        }
        return response()->json($response, $user ? 201 : 400);
    }
    //this is the first initial authentication for the api i.e who can access it
    public function login (Request $request)
    {
        $fields =$request->validate(
            [
                'email' => 'required|string',
                'password' => 'required|string',
            ]);

                $apiuser = Apiusers::where('email', $fields['email'])->first();

                if(!$apiuser || !Hash::check($fields['password'], $apiuser->password)) 
                {
                    return response (['message' => 'bad credentials'], 401);
                }

        $token = $apiuser->createToken('myapptoken')->plainTextToken;
        $response = 
        [
            'user' =>$apiuser,
            'token' =>$token
        ];

         return response($response, 201);
    }
    //this is the function that is called when user wants to login i.e not api user but api user customers login
    //normal customer login
    // public function userlogin (Request $request)
    // {
    //     $fields =$request->validate(
    //         [
    //             'email' => 'required|string',
    //             'password' => 'required|string',
    //         ]);

    //             $user = User::where('email', $fields['email'])->first();

    //             if(!$user || !Hash::check($fields['password'], $user->password)) 
    //             {
    //                 return response (['message' => 'bad credentials'], 401);
    //             }

    //     $response = 
    //     [
    //         'status' => 'successfully logged in',
    //     ];

    //      return response($response, 201);
    // }

        public function userlogin(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $fields['email'])->where('role', 'user')->first();

        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response(['message' => 'Bad credentials'], 401);
        }

        // Check if the user already has an existing token
        $existingToken = $user->tokens()->first();

        if ($existingToken) {
            // If an existing token is available, use it
            $token = $existingToken->plainTextToken;
        } else {
            // If no existing token, create a new one
            $token = $user->createToken('myapptoken')->plainTextToken;
        }

        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return response($response, 200);
    }

    //logout for api access
    public function logout (Request $request){
            auth()->user()->tokens()->delete();
            return [
                'message' => 'logged out',
            ];
    }

    public function profile()
    {
        // Retrieve the authenticated user
        $user = auth::user();
            $userInfo = User::getUserInfo()->find($user->id);
        
        if ($user) {
            // Load relationships
            // $user->load('details', 'wallet','deposits');

            // // You can customize the data you want to return in the response
            // $data = [
            //     'user' => $user,
            //     'user_detail' => $user->details,
            //     'user_wallet' => $user->wallet,
            //     'deposits' => $user->deposits
                
            // ];


            return response()->json(['status' => 'success', 'user' => $userInfo], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }
    }
}
