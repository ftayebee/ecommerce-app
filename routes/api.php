<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PrivateControllers\InventoryController;
use App\Http\Controllers\PrivateControllers\ProductController;
use App\Http\Controllers\PrivateControllers\UserController;

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::group(['prefix' => 'auth'], function () {
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('logout', [AuthController::class, 'logout']);
        Route::get('user', [AuthController::class, 'user']);
        
        Route::group(['prefix' => 'inventories'], function () {
            Route::get('/', [InventoryController::class, 'index']);
            Route::post('/store', [InventoryController::class, 'store']);
            Route::post('/update/{id}', [InventoryController::class, 'update']);
            Route::delete('/destroy/{id}', [InventoryController::class, 'destroy']);

            Route::group(['prefix' => '{inventory}/product'], function () {
              Route::get('/', [ProductController::class, 'index']);
              Route::post('/store', [ProductController::class, 'store']);
              Route::put('/update/{id}', [ProductController::class, 'update']);
              Route::delete('/destroy/{id}', [ProductController::class, 'destroy']);
            });
        });

        Route::group(['prefix' => 'users'], function () {
            Route::get('/', [UserController::class, 'index']);
            Route::get('/{user}', [UserController::class, 'show']);
            Route::put('/update/{user}', [UserController::class, 'update']);
            Route::delete('/destroy/{user}', [UserController::class, 'destroy']);
            Route::post('/{user}/assign-inventory', [UserController::class, 'assignInventory']);
            Route::post('/{user}/remove-inventory', [UserController::class, 'unassignInventory']);
        });
    });
});
