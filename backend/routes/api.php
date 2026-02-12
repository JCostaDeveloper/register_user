<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Route::get('/users',[UserController::class,'index']);
// Route::get('/post',[UserController::class,'store']);

//Cria as cinco rotas para o CRUD da entidade User
Route::apiResource('/users',UserController::class);