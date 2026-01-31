<?php

use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::apiResource('users', UserController::class);

Route::apiResource('users.accounts', AccountController::class);