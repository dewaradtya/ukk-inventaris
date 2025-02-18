<?php

use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\FineController;
use App\Http\Controllers\FineSettingController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\ReturnController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'home']);
Route::get('home', function () {
	return view('pages/landing-page/index');
})->name('home');

Route::view('/docs', 'documentation.index');

Route::group(['middleware' => 'auth'], function () {
	Route::resource('dashboard', DashboardController::class);

	Route::middleware(['userakses:Admin'])->group(function () {
		Route::resource('/type', TypeController::class);
		Route::get('/type-export', [TypeController::class, 'export'])->name('type.export');
		Route::resource('/room', RoomController::class);
		Route::get('/room-export', [RoomController::class, 'export'])->name('room.export');
		Route::resource('/level', LevelController::class);
		Route::resource('/inventory', InventoryController::class);
		Route::get('/inventory-export', [InventoryController::class, 'export'])->name('inventory.export');
		Route::resource('/user-management', UserManagementController::class);
		Route::get('/borrowing/export', [BorrowingController::class, 'export'])->name('borrowing.export');
		Route::get('/return/export', [ReturnController::class, 'export'])->name('return.export');
	});
	Route::middleware(['auth', 'userakses:Admin,Operator'])->group(function () {
		Route::put('/borrowing/{id}/update-status', [BorrowingController::class, 'updateStatus'])
			->name('borrowing.updateStatus');
		Route::resource('/return', ReturnController::class);
		Route::get('fine-settings', [FineSettingController::class, 'index'])->name('fine.settings');
		Route::put('fine/settings', [FineSettingController::class, 'update'])->name('fine.settings.update');
	});
	Route::resource('/employee', EmployeeController::class);
	Route::resource('/borrowing', BorrowingController::class);
	Route::get('/borrowing/{id}/proof', [BorrowingController::class, 'proof'])->name('borrowing.proof');
	Route::get('/return', [ReturnController::class, 'index'])->name('return.index');
	Route::get('/return/{id}/proof', [ReturnController::class, 'proof'])->name('return.proof');
	Route::get('/logout', [SessionsController::class, 'destroy']);
	Route::get('/user-profile', [InfoUserController::class, 'create'])->name('userProfile.create');
	Route::post('/user-profile', [InfoUserController::class, 'store']);
	Route::post('/user-profile/update-image', [InfoUserController::class, 'updateImage'])->name('profile.update.image');
	Route::resource('/fine', FineController::class);
	Route::post('/fine/{id}/pay', [FineController::class, 'payFine'])->name('fine.pay');
	Route::get('/login', function () {
		return view('dashboard');
	})->name('sign-up');
});

Route::group(['middleware' => 'guest'], function () {
	Route::get('/register', [RegisterController::class, 'create']);
	Route::post('/register', [RegisterController::class, 'store']);
	Route::get('/login', [SessionsController::class, 'create']);
	Route::post('/session', [SessionsController::class, 'store']);
	Route::get('/login/forgot-password', [ResetController::class, 'create']);
	Route::post('/forgot-password', [ResetController::class, 'sendEmail']);
	Route::get('/reset-password/{token}', [ResetController::class, 'resetPass'])->name('password.reset');
	Route::post('/reset-password', [ChangePasswordController::class, 'changePassword'])->name('password.update');
	Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.login');
	Route::get('/auth/google/callback', [GoogleController::class, 'callback']);
});

Route::get('/login', function () {
	return view('session/login-session');
})->name('login');
