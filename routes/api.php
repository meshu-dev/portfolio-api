<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TechnologyController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PrototypeController;

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

/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */

Route::get('/', [HomeController::class, 'index']);

Route::group(['prefix' => 'auth'], function ($router) {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth:sanctum')->group(function ($router) {
    Route::group(['prefix' => 'auth'], function ($router) {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::get('/user', [AuthController::class, 'userProfile']);    
    });

    Route::group(['prefix' => 'technologies'], function ($router) {
        Route::get('/', [TechnologyController::class, 'getAll']);
        Route::get('/{id}', [TechnologyController::class, 'get']);
        Route::post('/', [TechnologyController::class, 'add']);
        Route::put('/{id}', [TechnologyController::class, 'edit']);
        Route::delete('/{id}', [TechnologyController::class, 'delete']);    
    });

    Route::group(['prefix' => 'projects'], function ($router) {
        Route::get('/', [ProjectController::class, 'getAll']);
        Route::get('/{id}', [ProjectController::class, 'get']);
        Route::post('/', [ProjectController::class, 'add']);
        Route::put('/{id}', [ProjectController::class, 'edit']);
        Route::delete('/{id}', [ProjectController::class, 'delete']);   
    });

    Route::group(['prefix' => 'prototypes'], function ($router) {
        Route::get('/', [PrototypeController::class, 'getAll']);
        Route::get('/{id}', [PrototypeController::class, 'get']);
        Route::post('/', [PrototypeController::class, 'add']);
        Route::put('/{id}', [PrototypeController::class, 'edit']);
        Route::delete('/{id}', [PrototypeController::class, 'delete']);   
    });
});
