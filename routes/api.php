<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\AdminUserController;
use App\Http\Controllers\API\MemberController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\OrderController;


Route::apiResource('/adminUsers', AdminUserController::class);
Route::apiResource('/users', UserController::class);
Route::apiResource('/members', MemberController::class);
Route::apiResource('/products', ProductController::class);
