<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();

Route::get('/', [Controller::class, 'index']);

Route::group(['middleware' => ['api', 'checkPassword', 'changeLanguage']], function () {
    Route::get('users', function () {
        return User::paginate(10);
    });
    Route::group(['prefix' => 'admin'], function () {
        Route::post('login', [AdminController::class, 'login']);
    });
});

// Route::post('users', function ($id) {
    //     return User::select('id', 'name');
// });
// });
