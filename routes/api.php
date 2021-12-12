<?php

use App\Functional\Account\IAccount;
use App\Http\Controllers\AdminController\BrandController;
use App\Http\Controllers\AdminController\ServiceController;
use App\Http\Controllers\UserController\AccountController;
use App\Http\Controllers\UserController\ModelController;
use App\Http\Controllers\UserController\OrderController;
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
Route::group(['middleware' => ['auth:api']], function () { 
    
    Route::resource('order', OrderController::class);
    Route::resource('resource', ServiceController::class, [
        'only' => [
            'index'
        ]
    ]);
    
    Route::post("/auth/add_balance",[AccountController::class, 'addBalance']);

    Route::get("/auth/get_balance",[AccountController::class, 'getBalance']);
});

Route::group(['middleware' => ['auth:admin']], function () { 
    Route::apiResources([
        "brand" => BrandController::class,
        "model" => ModelController::class,
        "service" => ServiceController::class,
    ]);

    Route::post("/auth/add_balance",[AccountController::class, 'addBalance']);

    Route::get("/auth/get_balance",[AccountController::class, 'getBalance']);
});


Route::get("/auth/login",[AccountController::class, 'loginV'])->name('login');

Route::post("/auth/login",[AccountController::class, 'login']);

Route::post("/auth/register",[AccountController::class, 'register']);
