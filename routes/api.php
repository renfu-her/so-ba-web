<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\MemberController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\OrderController;


Route::get('/adminUsers', [UserController::class, 'adminUsers']);
Route::get('/users', [UserController::class, 'users']);
