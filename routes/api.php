<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ServiceController;
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

// Route::get('/', [Controller::class, 'index']);

// Route::group(['middleware' => ['api', 'checkPassword', 'changeLanguage']], function () {
//     Route::get('users', function () {
//         return User::paginate(10);
//     });
//     Route::group(['prefix' => 'admin'], function () {
//         Route::post('login', [AdminController::class, 'login']);

//         Route::post('logout', [AdminController::class, 'logout'])->middleware('auth.guard:admin-api');

//         Route::post('logout', [AdminController::class, 'login']);
//     });
// });

// Route::post('users', function ($id) {
    //     return User::select('id', 'name');
// });
// });

// Route::post('/s', [ServiceController::class, 'store']);

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth',
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::post('/user-profile', [AuthController::class, 'userProfile']);
});

Route::middleware(['jwt.verify'])->group(function () {
    Route::get('/users', [Controller::class, 'index']);
});

// Route::resource('services', ServiceController::class);
