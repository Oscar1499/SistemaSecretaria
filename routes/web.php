<?php

use App\Http\Controllers\ActaController;
use App\Http\Controllers\AcuerdoController;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\CertificacionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/certificacion', [CertificacionController::class, 'index'])->name('certificacion.index');
Route::middleware(['auth'])->group(function () {
    Route::resource('certificacion', CertificacionController::class);
});

Route::post('/obtener-acuerdos', [CertificacionController::class, 'obtenerAcuerdos'])->name('obtener.acuerdos');

Route::get('/libros', [LibroController::class, 'index'])->name('libros.index');
Route::get('/actas/create', [ActaController::class, 'create'])->name('actas.create');
Route::post('/actas', [ActaController::class, 'store'])->name('actas.store');

Route::resource('actas', ActaController::class)->middleware('auth');
Route::resource('acuerdos', AcuerdoController::class);
Route::resource('personal', PersonalController::class);
Route::post('/obtener-presentes', [AcuerdoController::class, 'obtenerPresentes'])->name('obtener.presentes');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::middleware(['auth'])->group(function () {
    Route::resource('libros', LibroController::class);
});
