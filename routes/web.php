<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PlanificacionesController;
use App\Http\Controllers\Api\ApiController;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', HomeController::class);


Route::get('/users/create', [UserController::class, 'create']);

Route::post('/users/store', [UserController::class, 'store']);

Route::get('/users', [UserController::class, 'index']);

Route::get('/users/{id}', [UserController::class, 'show']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/planificaciones', [PlanificacionesController::class, 'index']);

Route::get('/planificaciones/create', [PlanificacionesController::class, 'create']);


Route::post('/planificaciones/store', [PlanificacionesController::class, 'store']);

Route::get('/planificaciones/{id}/edit', [PlanificacionesController::class, 'edit']);

Route::post('/planificaciones/update', [PlanificacionesController::class, 'update']);

Route::post('/planificaciones/destroy', [PlanificacionesController::class, 'destroy']);


Route::get('/token', function () {
    return csrf_token(); 
});


// API
Route::get("/api/planificaciones/", [ApiController::class, 'index']);

Route::get("/api/planificaciones/{id}", [ApiController::class, 'show']);

Route::delete("/api/planificaciones/{id}", [ApiController::class, 'destroy']);

Route::put("/api/planificaciones/{id}", [ApiController::class, 'update']);

Route::post("/api/planificaciones/", [ApiController::class, 'store']);


