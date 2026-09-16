<?php

use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

// Todo routes
Route::get('/', [TodoController::class, 'index'])->name('todo.index');
Route::post('/', [TodoController::class, 'store'])->name('todo.store');
Route::patch('/{id}', [TodoController::class, 'update'])->name('todo.update');
Route::delete('/{id}', [TodoController::class, 'destroy'])->name('todo.destroy');

// Switch theme route
Route::get('/theme/{theme}', [TodoController::class, 'switchTheme'])->name('theme.switch');