<?php

use App\Http\Controllers\Api\IdentityController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/identities', [IdentityController::class, 'index']);
