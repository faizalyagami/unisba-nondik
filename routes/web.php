<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\StudentActivityController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubActivityController;
use App\Http\Controllers\UserController;
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

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);


Route::prefix('student')->name('student.')->group(function () {
	Route::get('/', [StudentController::class, 'index'])->name('index');
	Route::post('/', [StudentController::class, 'store'])->name('store');
	Route::get('/create', [StudentController::class, 'create'])->name('create');
	Route::get('/show/{student}', [StudentController::class, 'show'])->name('show');
	Route::get('/edit/{student}', [StudentController::class, 'edit'])->name('edit');
	Route::post('/update/{student}', [StudentController::class, 'update'])->name('update');
	
	Route::get('/export-format', [StudentController::class, 'exportFormatStudent'])->name('export-format');

	Route::get('/import', [StudentController::class, 'import'])->name('import');
	Route::post('/import/read', [StudentController::class, 'read'])->name('read');
	Route::post('/import/process', [StudentController::class, 'process'])->name('process');

	Route::prefix('activity')->name('activity.')->group(function () {
		Route::get('/', [StudentActivityController::class, 'index'])->name('index');
		Route::post('/', [StudentActivityController::class, 'store'])->name('store');
		Route::get('/create', [StudentActivityController::class, 'create'])->name('create');
		Route::get('/show/{studentActivity}', [StudentActivityController::class, 'show'])->name('show');
		Route::get('/edit/{studentActivity}', [StudentActivityController::class, 'edit'])->name('edit');
		Route::post('/update/{studentActivity}', [StudentActivityController::class, 'update'])->name('update');
		Route::post('/approve/{studentActivity}', [StudentActivityController::class, 'approve'])->name('approve');
	});
});

Route::prefix('activity')->name('activity.')->group(function () {
	Route::get('/', [ActivityController::class, 'index'])->name('index');
	Route::post('/', [ActivityController::class, 'store'])->name('store');
	Route::get('/create', [ActivityController::class, 'create'])->name('create');
	Route::get('/show/{activity}', [ActivityController::class, 'show'])->name('show');
	Route::get('/edit/{activity}', [ActivityController::class, 'edit'])->name('edit');
	Route::post('/update/{activity}', [ActivityController::class, 'update'])->name('update');

	Route::prefix('{activity}')->name('sub.')->group(function () {
		Route::post('/', [SubActivityController::class, 'store'])->name('store');
		Route::get('/create', [SubActivityController::class, 'create'])->name('create');
		Route::get('/show/{subActivity}', [SubActivityController::class, 'show'])->name('show');
		Route::get('/edit/{subActivity}', [SubActivityController::class, 'edit'])->name('edit');
		Route::post('/update/{subActivity}', [SubActivityController::class, 'update'])->name('update');
	});
});

Route::prefix('user')->name('user.')->group(function () {
	Route::get('/', [UserController::class, 'index'])->name('index');
	Route::post('/', [UserController::class, 'store'])->name('store');
	Route::get('/create', [UserController::class, 'create'])->name('create');
	Route::get('/show/{user}', [UserController::class, 'show'])->name('show');
	Route::get('/edit/{user}', [UserController::class, 'edit'])->name('edit');
	Route::post('/update/{user}', [UserController::class, 'update'])->name('update');
	Route::post('/reset-password', [UserController::class, 'resetPassword'])->name('reset-password');
});
