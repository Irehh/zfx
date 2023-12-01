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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//public routes

Route::post('/products/{id}', [ ProductController::class, 'show']);
Route::get('/products/search/{name}', [ ProductController::class, 'search']); 

Route::post('/login', [ AuthController::class, 'login']);
 
 //protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    
    Route::post('/auth/login', [ AuthController::class, 'userlogin']);
    Route::put('/auth/register', [ AuthController::class, 'register']);
    Route::delete('/products/{id}', [ ProductController::class, 'destroy']);
    Route::post('/logout', [ AuthController::class, 'logout']);

    Route::group(['prefix' => '/admin', 'middleware' => ['auth', 'admin']], function () {
        
    });

    Route::group(['prefix' => '/user', 'middleware' => ['auth', 'user']], function () {
        return "welcome";
        // Route::get('/profile', [ UserController::class, 'profile']);
    });

    // Route::prefix('user')->group(function() {
    //     Route::post('/deposit', [ UserController::class, 'deposit']);
    //     
    //     Route::post('/change-password', [ AuthController::class, 'change-password']);
    // });

});