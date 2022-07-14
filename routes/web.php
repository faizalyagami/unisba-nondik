<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome', [
		'active' => 'home'
	]);
}); //->middleware('auth');

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);


Route::prefix('student')->name('student.')->group(function () {
	Route::get('/', [StudentController::class, 'index'])->name('index');
	Route::post('/', [StudentController::class, 'store'])->name('store');
	Route::get('/create', [StudentController::class, 'create'])->name('create');
	Route::get('/edit/{student}', [StudentController::class, 'edit'])->name('edit');
	Route::post('/edit/{student}', [StudentController::class, 'update'])->name('update');
});
