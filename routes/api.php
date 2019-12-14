<?php

use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;

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

Route::post("register", 'Auth\RegisterController@register');
Route::post('login', 'Auth\LoginController@login')->name("login");


Route::group(["middleware" => 'auth:api'], function () {
    Route::post('logout', 'Auth\LoginController@logout');
    Route::apiResource('items', 'ItemController');
    Route::apiResource('polls', 'PollController');
    Route::apiResource('groups', 'GroupController');
    Route::get('users/by-mail/{email}', function($email)
    {

        $user = User::where('email',$email)->first();
        if($user != null)
        {
            return new UserResource($user); 
        }
        else
        {
            return response()->json([
                'code'      => 404,
                'message'   => "User not found",
            ], 404);
        }
    });
});