<?php

use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TodoController::class, 'index'])->name('todo.index');
Route::get("/create_todo", [TodoController::class, "create"])->name("todo.create");
Route::post('/', [TodoController::class, 'store'])->name('todo.store');
Route::patch('/{id}', [TodoController::class, 'update'])->name('todo.update');
Route::delete('/{id}', [TodoController::class, 'destroy'])->name('todo.destroy');