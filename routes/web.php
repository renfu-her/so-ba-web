<?php

use Illuminate\Support\Facades\Route;

Route::any('{any}', function () {
    return view('app'); // 確保這裡返回的是你的 Vue 入口文件，通常是 app.blade.php
})->where('any', '.*');