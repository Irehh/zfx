<?php

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


//public routes

Route::post('david/register', [ AuthController::class, 'apiregister']);
Route::get('/products/search/{name}', [ ProductController::class, 'search']); 

Route::post('/login', [ AuthController::class, 'login']);
 
 //protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    
    Route::post('/auth/login', [ AuthController::class, 'userlogin']);
    Route::put('/auth/register', [ AuthController::class, 'register']);
    Route::delete('/products/{id}', [ ProductController::class, 'destroy']);
    Route::post('/logout', [ AuthController::class, 'logout']);
});

Route::group(['middleware' => ['auth:sanctum']], function () {
    
Route::get('/user/profile', [ UserController::class, 'profile']);
Route::get('/user/{slug}', [ UserController::class, 'showProfile']);
Route::put('/user/profile-update/{slug}', [ UserController::class, 'updateProfile']);

});

// Route::group(['middleware' => ['auth:sanctum', 'SecondAuthenticationMiddleware:user']], function () {
//     // Routes that require both authentications and admin role
//     Route::get('user/profile', [ UserController::class, 'profile']);
// });
