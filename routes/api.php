<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::post('/subpages/{slug}/posts/{postSlug}/comments', [CommentController::class, 'store'])
    //->name('comments.store');

//Route::post('/comments/{comment}/toggle-like', 'CommentController@toggleLike')->name('comments.toggleLike');

