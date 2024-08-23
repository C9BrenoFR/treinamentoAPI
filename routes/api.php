<?php

use App\Http\Controllers\Api\DuTrainingController;
use App\Http\Controllers\Api\DuUserController;
use App\Http\Controllers\Api\IdentityController;
use App\Http\Controllers\Api\PauloCreditCardController;
use App\Http\Controllers\Api\PauloUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/identities', [IdentityController::class, 'index']);


// Rotas de api do Paulo 
Route::post('/paulo/user', [PauloUserController::class, 'store']);
Route::get('/paulo/user/{id}', [PauloUserController::class, 'show']);
Route::put('/paulo/user/{id}', [PauloUserController::class, 'update']);
Route::delete('/paulo/user/{id}', [PauloUserController::class, 'destroy']);


Route::post('/paulo/creditCard', [PauloCreditCardController::class, 'store']);
Route::put('/paulo/creditCard/{id}', [PauloCreditCardController::class, 'update']);
Route::delete('/paulo/creditCard/{id}', [PauloCreditCardController::class, 'destroy']);

//Rotas de api do Du
Route::post('/du/user', [DuUserController::class, 'store']);
Route::put('/du/user/{id}', [DuUserController::class, 'update']);
Route::delete('/du/user/{id}', [DuUserController::class, 'destroy']);
Route::get('/du/user/{id}', [DuUserController::class, 'show']);

Route::post('/du/training', [DuTrainingController::class, 'store']);
Route::put('/du/training/{id}', [DuTrainingController::class, 'update']);
Route::delete('/du/training/{id}', [DuTrainingController::class, 'destroy']);
