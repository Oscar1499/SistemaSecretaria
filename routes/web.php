<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\ActaController;
use App\Http\Controllers\AcuerdoController;
use App\Http\Controllers\PersonalController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/actas/create', [ActaController::class, 'create'])->name('actas.create');
Route::post('/actas', [ActaController::class, 'store'])->name('actas.store');

Route::resource('libros', LibroController::class);
Route::resource('actas', ActaController::class);
Route::resource('acuerdos', AcuerdoController::class);
Route::resource('personal', PersonalController::class);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
