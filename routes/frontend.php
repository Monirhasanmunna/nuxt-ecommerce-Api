<?php

use App\Http\Controllers\Frontent\AuthenticateController;
use Illuminate\Support\Facades\Route;

// Frontent Route Here

Route::post('/login', [AuthenticateController::class, 'login']);
Route::post('/register', [AuthenticateController::class, 'register']);