<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\TransactionController;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
| Rotas que só funcionam em domínios de tenants e já estão sob o prefixo /api
*/

// A URL final será /api/login
Route::post('/login', [AuthController::class, 'login']);

// Grupo de rotas que exigem autenticação
Route::middleware('auth:sanctum')->group(function () {
    // A URL final será /api/transactions
    Route::get('/transactions', [TransactionController::class, 'index']);
    Route::post('/transactions', [TransactionController::class, 'store']);
});
