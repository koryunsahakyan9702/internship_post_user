<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(["prefix"=>"users"],function(){
    Route::get("/",[\App\Http\Controllers\UserController::class,'all']);
    Route::post("/register",[\App\Http\Controllers\UserController::class,"create"]);
    Route::post("/login",[\App\Http\Controllers\UserController::class,'login']);
    Route::put('/update/{id}',[\App\Http\Controllers\UserController::class,"update"])->middleware("auth:sanctum");
    Route::delete('/delete/{id}',[\App\Http\Controllers\UserController::class,"destroy"])->middleware("auth:sanctum");

});
Route::group(["prefix"=>"posts"],function(){
    Route::get("/",[\App\Http\Controllers\PostController::class,"all"]);
    Route::post("/",[\App\Http\Controllers\PostController::class,"create"])->middleware("auth:sanctum");
    Route::get("/{id}",[\App\Http\Controllers\PostController::class,"findById"])->middleware("auth:sanctum");
    Route::delete('/{id}',[\App\Http\Controllers\PostController::class,"destroy"])->middleware("auth:sanctum");
    Route::put("/update/{id}",[\App\Http\Controllers\PostController::class,"updatePost"])->middleware("auth:sanctum");
    Route::post("/like/{id}",[\App\Http\Controllers\PostController::class,"likePost"])->middleware("auth:sanctum");
});
Route::group(["prefix"=>"comment"],function() {
    Route::post("/{id}", [\App\Http\Controllers\CommentController::class, "writeComment"])->middleware("auth:sanctum");
    Route::post("reply/{id}/{commentId}", [\App\Http\Controllers\CommentController::class, "replyComment"])->middleware("auth:sanctum");
    Route::delete("/{commentId}", [\App\Http\Controllers\CommentController::class, "destroyComment"])->middleware("auth:sanctum");
    Route::post("/likes/{id}", [\App\Http\Controllers\CommentController::class, "likeComment"])->middleware("auth:sanctum");
});

