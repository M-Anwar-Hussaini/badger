<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\api\v1\AuthorController;
use App\Http\Controllers\api\v1\ArticleController;
use Illuminate\Http\Response;

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post(uri: '/register', action: [AuthController::class, 'register'])->name('register');

Route::prefix('/v1')->middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('/articles', ArticleController::class);
    Route::get('/authors/{user}', [AuthorController::class, 'show'])->name('authors');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return response()->json(
            ['user' => $request->user()]
            ,
            Response::HTTP_OK
        );
    });
    Route::post('/logout', [AuthController::class, 'logout']);
    ;
});
