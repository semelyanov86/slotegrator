<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\PrizeController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\ProductPrizesController;
use App\Http\Controllers\Api\UserTransactionsController;
use App\Http\Controllers\Api\PrizeTransactionsController;

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

Route::post('/login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')
    ->get('/user', function (Request $request) {
        return $request->user();
    })
    ->name('api.user');

Route::name('api.')
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::apiResource('roles', RoleController::class);
        Route::apiResource('permissions', PermissionController::class);

        Route::apiResource('users', UserController::class);

        // User Transactions
        Route::get('/users/{user}/transactions', [
            UserTransactionsController::class,
            'index',
        ])->name('users.transactions.index');
        Route::post('/users/{user}/transactions', [
            UserTransactionsController::class,
            'store',
        ])->name('users.transactions.store');

        Route::apiResource('transactions', TransactionController::class);

        Route::apiResource('prizes', PrizeController::class);

        // Prize Transactions
        Route::get('/prizes/{prize}/transactions', [
            PrizeTransactionsController::class,
            'index',
        ])->name('prizes.transactions.index');
        Route::post('/prizes/{prize}/transactions', [
            PrizeTransactionsController::class,
            'store',
        ])->name('prizes.transactions.store');

        Route::apiResource('products', ProductController::class);

        // Product Prizes
        Route::get('/products/{product}/prizes', [
            ProductPrizesController::class,
            'index',
        ])->name('products.prizes.index');
        Route::post('/products/{product}/prizes', [
            ProductPrizesController::class,
            'store',
        ])->name('products.prizes.store');
    });
