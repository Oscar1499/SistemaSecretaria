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

Route::get('/libros/create', [PersonalController::class, 'obtenerAlcaldesas']);

Route::get('/libros', [LibroController::class, 'index'])->name('libros.index');
Route::get('/actas/create', [ActaController::class, 'create'])->name('actas.create');
Route::post('/actas', [ActaController::class, 'store'])->name('actas.store');


Route::resource('actas', ActaController::class)->middleware('auth');
Route::resource('acuerdos', AcuerdoController::class);
Route::resource('personal', PersonalController::class);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::middleware(['auth'])->group(function () {
    Route::resource('libros', LibroController::class);
});
