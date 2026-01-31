<?php

use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::apiResource('users', UserController::class);

Route::apiResource('users.accounts', AccountController::class);

Route::post('users/{user}/transactions/transfer', [TransactionController::class, 'transfer']);

Route::get('users/{user}/transactions', [TransactionController::class, 'getUserTransactions']);

Route::get('users/{user}/accounts/{account}/transactions/sender', [TransactionController::class, 'getAccountTransactionsAsSender']);

Route::get('users/{user}/accounts/{account}/transactions/receiver', [TransactionController::class, 'getAccountTransactionsAsReceiver']);