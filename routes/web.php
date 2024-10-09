<?php

use Illuminate\Http\Request;
use App\Http\Controllers\SendEmail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use Illuminate\Auth\Events\PasswordReset;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\SubActivityController;
use App\Http\Controllers\StudentActivityController;

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

Route::get('/', [HomeController::class, 'index'])->name('home')->middleware('auth');

Route::prefix('profile')->name('profile.')->middleware('auth')->group(function () {
	Route::get('/', [HomeController::class, 'profile'])->name('index');
	Route::get('/edit', [HomeController::class, 'editProfile'])->name('edit');
	Route::post('/update', [HomeController::class, 'updateProfile'])->name('update');
	Route::get('/edit-password', [HomeController::class, 'editPasswordProfile'])->name('edit-password');
	Route::post('/update-password', [HomeController::class, 'updatePasswordProfile'])->name('update-password');
	// Route::get('/print-certificate', [HomeController::class, 'printCertificate'])->name('print-certificate');
	Route::get('/generate-pdf', [HomeController::class, 'generatePDF'])->name('generate-pdf');
});
Route::get('/template', [HomeController::class, 'template'])->name('template');

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');


Route::prefix('student')->name('student.')->middleware('auth')->group(function () {
	Route::get('/', [StudentController::class, 'index'])->name('index')->middleware('review');
	Route::post('/', [StudentController::class, 'store'])->name('store')->middleware('review');
	Route::get('/create', [StudentController::class, 'create'])->name('create')->middleware('review');
	Route::get('/show/{student}', [StudentController::class, 'show'])->name('show')->middleware('review');
	Route::get('/edit/{student}', [StudentController::class, 'edit'])->name('edit')->middleware('review');
	Route::post('/update/{student}', [StudentController::class, 'update'])->name('update')->middleware('review');
	
	Route::get('/export-format', [StudentController::class, 'exportFormatStudent'])->name('export-format')->middleware('review');
	Route::get('/export-students', [StudentController::class, 'exportStudents'])->name('export-students')->middleware('review');

	Route::post('/approve-certificate', [StudentController::class, 'approveCertificate'])->name('approve-certificate')->middleware('review');

	Route::get('/import', [StudentController::class, 'import'])->name('import')->middleware('review');
	Route::post('/import/read', [StudentController::class, 'read'])->name('read')->middleware('review');
	Route::post('/import/process', [StudentController::class, 'process'])->name('process')->middleware('review');

	Route::prefix('activity')->name('activity.')->group(function () {
		Route::get('/', [StudentActivityController::class, 'index'])->name('index');
		Route::get('/details', [StudentActivityController::class, 'details'])->name('details');
		Route::post('/', [StudentActivityController::class, 'store'])->name('store');
		Route::get('/create', [StudentActivityController::class, 'create'])->name('create');
		Route::get('/show/{studentActivity}', [StudentActivityController::class, 'show'])->name('show');
		Route::get('/edit/{studentActivity}', [StudentActivityController::class, 'edit'])->name('edit');
		Route::post('/update/{studentActivity}', [StudentActivityController::class, 'update'])->name('update');
		Route::post('/approve/{studentActivity}', [StudentActivityController::class, 'approve'])->name('approve')->middleware('review');
		Route::post('/review/{studentActivity}', [StudentActivityController::class, 'review'])->name('review')->middleware('review');
	});
});

Route::prefix('activity')->name('activity.')->middleware('admin')->group(function () {
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

Route::prefix('user')->name('user.')->middleware(['wadek'])->group(function () {
	Route::get('/', [UserController::class, 'index'])->name('index');
	Route::post('/', [UserController::class, 'store'])->name('store');
	Route::get('/create', [UserController::class, 'create'])->name('create');
	Route::get('/show/{user}', [UserController::class, 'show'])->name('show')->middleware('wadek');
	Route::get('/edit/{user}', [UserController::class, 'edit'])->name('edit')->middleware('wadek');
	Route::post('/update/{user}', [UserController::class, 'update'])->name('update')->middleware('wadek');
	Route::post('/reset-password', [UserController::class, 'resetPassword'])->name('reset-password');
});

Route::prefix('information')->name('information.')->middleware('admin')->group(function () {
	Route::get('/', [InformationController::class, 'index'])->name('index');
	Route::post('/', [InformationController::class, 'store'])->name('store');
	Route::get('/create', [InformationController::class, 'create'])->name('create');
	Route::get('/show/{information}', [InformationController::class, 'show'])->name('show');
	Route::get('/edit/{information}', [InformationController::class, 'edit'])->name('edit');
	Route::post('/update/{information}', [InformationController::class, 'update'])->name('update');
});

Route::get('/forgot-password', function() {
	return view('auth.forgot-password');
})->middleware('guest')->name('password-request');

Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);
 
    $status = Password::sendResetLink(
        $request->only('email')
    );
 
    return $status === Password::RESET_LINK_SENT
                ? back()->with(['status' => __($status)])
                : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.email');

Route::get('/reset-password/{token}', function($token) {
	return view('auth.reset-password', ['token' => $token]);
	//return 'berhasil kirim email notifikasi reset password';
})->middleware('guest')->name('password.reset');

Route::post('/reset-password', function(Request $request) {
	$request->validate([
		'token' => 'required',
		'email' => 'required|email',
		'password' => 'required|min:8|confirmed',
	]);

	$status = Password::reset(
		$request->only('email', 'password', 'password_confirmation', 'token'),
		function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));
 
            $user->save();
 
            event(new PasswordReset($user));
        }
	);
	
	return $status === Password::PASSWORD_RESET
	? redirect()->route('login')->withSuccess('Password has been changed')
	: back()->withErrors(['email' => [__($status)]]);
	
	
})->middleware('guest')->name('password.update');
// Route::post('/forgot-password', function() {

// })->middleware('guest')->name('password.email');

Route::get('/send-email', [SendEmail::class, 'index']);