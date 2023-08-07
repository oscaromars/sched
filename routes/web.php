<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\AgendarController;
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
//REACT ANGULAR
/*
Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');
*/

Route::get('/', [AgendaController::class, 'index'])->name('agenda');
Route::get('/agendar', [AgendarController::class, 'index'])->name('agendar');
Route::post('/agendar', [AgendarController::class, 'index'])->name('agendar');
