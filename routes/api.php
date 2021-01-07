<?php

use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\BookListController;
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

Route::prefix('book-list/{bookListId}')
    ->group(function () {
        Route::get('/', [BookListController::class, 'index']);
        Route::post('/', [BookListController::class, 'postBooks']);
        Route::prefix('book')
            ->group(function () {
                Route::put('/', [BookListController::class, 'putBook']);
                Route::delete('{bookId}', [BookListController::class, 'deleteBook']);
            });
    });

Route::get('book/{bookId}', [BookController::class, 'index']);
