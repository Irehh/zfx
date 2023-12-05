<?php

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;

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

Route::post('/products/products/search/register', [ AuthController::class, 'apiregister']);
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
    
Route::get('/user/profile', [ AuthController::class, 'profile']);

});

// Route::group(['middleware' => ['auth:sanctum', 'SecondAuthenticationMiddleware:user']], function () {
//     // Routes that require both authentications and admin role
//     Route::get('user/profile', [ UserController::class, 'profile']);
// });
