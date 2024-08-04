<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StudentController;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/get-data', [StudentController::class, 'getData'])->name('get-data');
Route::get('/create', [StudentController::class, 'create'])->name('student-create');
Route::post('/store', [StudentController::class, 'store'])->name('student-store');
Route::get('/student/{id}/edit', [StudentController::class, 'edit'])->name('student-edit');
Route::post('/student/{id}/update', [StudentController::class, 'update'])->name('student-update');
Route::delete('/student/{id}', [StudentController::class, 'destroy'])->name('student-destroy');

