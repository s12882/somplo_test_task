<?php

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SellerController;
use Illuminate\Support\Facades\Route;

Route::post('/product/set_data', [ProductController::class, 'setData']);
Route::get('/product/get_data/{id}', [ProductController::class, 'getData']);
Route::post('/product/update_data_bulk', [ProductController::class, 'updateDataBulk']);
Route::post('/bulk_insert', [ProductController::class, 'bulkInsert']);

Route::post('/seller/set_data', [SellerController::class, 'setData']);
