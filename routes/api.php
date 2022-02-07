<?php

use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RatingController;
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


// authentaction routes 
Route::prefix("auth")->group(function() {
    Route::post("login", [AuthController::class, "login"]);
    Route::post("register", [AuthController::class, "register"]);
});


Route::middleware("auth:api")->group(function(){

    Route::prefix("admin")->middleware("is.admin")->group(function(){

        Route::apiResource("user", UserController::class);
        Route::apiResource("book", BookController::class);
        Route::apiResource("section", SectionController::class);
    });

    Route::get("me", [ProfileController::class , 'getProfile']);
    Route::put("me/update", [ProfileController::class, "updateProfile"]);
    Route::apiResource("me/favorite", FavoriteController::class)->only(["index", "store", "destroy"]);
    Route::apiResource("book/{bookId}/rating", RatingController::class);
});


Route::apiResource("sections", BookController::class)->only(["index"]);
Route::apiResource("book", BookController::class)->only(["index", "show"]);
Route::apiResource("book/{bookId}/rating", RatingController::class)->only(["index"]);