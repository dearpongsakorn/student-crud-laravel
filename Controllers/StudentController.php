<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

Route::get('/', [StudentController::class, 'index']);

Route::post('/add', [StudentController::class, 'add']);

Route::post('/update/{id}', [StudentController::class, 'update']);

Route::get('/delete/{id}', [StudentController::class, 'delete']);
