<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\TransactionController;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| O Laravel já adiciona o prefixo /api e o middleware 'api' automaticamente.
| Nós só precisamos adicionar os middlewares de tenancy.
*/

Route::middleware([
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function() {

    // A URL final será /api/login
    Route::post('login', [AuthController::class, 'login'])->name('login');

    // Grupo de rotas que exigem autenticação
    Route::middleware('auth:sanctum')->group(function () {
        // A URL final será /api/transactions
        Route::get('transactions', [TransactionController::class, 'index']);
        Route::post('transactions', [TransactionController::class, 'store']);
    });
});
