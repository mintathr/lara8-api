<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\TransactionController;
use App\Models\Transaction;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('transaction', TransactionController::class)->except(['create', 'edit']);
/* Route::get('/transaction', [TransactionController::class, 'index']);
Route::post('/transaction', [TransactionController::class, 'store']);
Route::get('/transaction/{id}', [TransactionController::class, 'show']);
Route::put('/transaction/{id}', [TransactionController::class, 'update']);
Route::delete('/transaction/{id}', [TransactionController::class, 'destroy']); */

####### POST ######
Route::get('/post', [PostController::class, 'index']);
Route::post('/post', [PostController::class, 'store']);
Route::get('/post/{id}', [PostController::class, 'show']);
Route::put('/post/{id}', [PostController::class, 'update']);
Route::delete('/post/{id}', [PostController::class, 'destroy']);
