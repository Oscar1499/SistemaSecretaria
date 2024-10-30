<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\ActaController;
use App\Http\Controllers\AcuerdoController;
use App\Http\Controllers\PersonalController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/actas/create', [ActaController::class, 'create'])->name('actas.create');
Route::post('/actas', [ActaController::class, 'store'])->name('actas.store');

Route::resource('libros', LibroController::class);
Route::resource('actas', ActaController::class);
Route::resource('acuerdos', AcuerdoController::class);
Route::resource('personales', PersonalController::class);

