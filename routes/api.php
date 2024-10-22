<?php

use App\Http\Controllers\api\v1\ArticleController;
use App\Http\Controllers\api\v1\AuthorController;
use Illuminate\Support\Facades\Route;

Route::prefix('/v1')->group(function () {
    Route::apiResource('/articles', ArticleController::class);
    Route::get('/authors/{user}', [AuthorController::class, 'show'])->name('authors');
});
