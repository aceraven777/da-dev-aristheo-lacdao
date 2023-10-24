<?php

use App\Http\Controllers\TodoItemController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/todo-items', [TodoItemController::class, 'index'])->name('todo-item.index');
Route::post('/todo-items', [TodoItemController::class, 'store'])->name('todo-item.store');
Route::delete('/todo-items/{id}', [TodoItemController::class, 'destroy'])->name('todo-item.destroy');
Route::post('/todo-items/{id}/toggle-completed', [TodoItemController::class, 'toggleCompleted'])->name('todo-item.toggle-completed');
