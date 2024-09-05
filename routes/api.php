<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:api', 'scope:view-user')->get('/user-sso', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->get('/logout-sso', function (Request $request) {
    $user = $request->user();
    $accessToken = $user->token();

    DB::table('oauth_refresh_tokens')->where('access_token_id', $accessToken->id)->delete();

    $accessToken->delete();

    return response()->json([
            'message' => 'Revoked',
    ]);
});
