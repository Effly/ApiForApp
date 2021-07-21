<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/register', [AuthController::class,'register']);
Route::post('/login', [AuthController::class,'login']);
Route::post('/password/reset', [AuthController::class,'changePassword']);
Route::post('/get-code', [AuthController::class,'getCode'])->name('get-code');
Route::post('/get-code-change', [AuthController::class,'getCodeForChangePass']);
//Route::get('/pre-get-code', function (){return view('testpass');})->name('pre-get-code');




//Route::get('/delete-code', [AuthController::class,'deleteTest']);
