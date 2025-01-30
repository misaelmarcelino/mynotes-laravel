<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\CheckIsLogged;
use App\Http\Middleware\CheckIsNotLogged;

Route::middleware([CheckIsNotLogged::class])->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/loginsubmit', [AuthController::class, 'loginSubmit'])->name('loginSubmit');
});

Route::middleware([CheckIsLogged::class])->group(function () {
    Route::get('/', [MainController::class, 'index'])->name('home');
    Route::get('/newNote', [MainController::class, 'newNote'])->name('new');
    Route::post('/newNoteSubmit', [MainController::class, 'newNoteSubmit'])->name('newNoteSubmit');

    Route::post('/edit/{id}', [MainController::class, 'editNote'])->name('edit');
    Route::post('/delete/{id}', [MainController::class, 'deleteNote'])->name('delete');

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

});

