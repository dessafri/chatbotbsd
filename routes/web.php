<?php

use App\Http\Controllers\CabangController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PenagihanController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\SettingController;
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
Route::group(['middleware' => 'auth'], function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    // Route::get('dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');

    Route::get('tables', function () {
        return view('tables');
    })->name('tables');

    Route::get('static-sign-in', function () {
        return view('static-sign-in');
    })->name('sign-in');

    Route::get('/setting/status-chatbot', [SettingController::class, 'statusChatbot'])->name('statusChatbot');

    Route::resource('penagihan', PenagihanController::class);
    Route::get('penagihan/upload-bukti-faktur', [PenagihanController::class, 'show'])->name('penagihan.faktur');
    Route::post('/upload-bukti-faktur', [PenagihanController::class, 'uploadBuktiFaktur'])->name('upload.bukti.faktur');
    Route::post('/update-status/{id}', [PenagihanController::class, 'updateStatus']);
    Route::post('import-excel', [PenagihanController::class, 'importExcel'])->name('import.excel');
    Route::resource('cabang', CabangController::class);
    Route::resource('settings', SettingController::class);
    Route::post('/update-status-chatbot', [SettingController::class, 'updateStatus']);
    Route::post('/update-qr-chatbot', [SettingController::class, 'updateQr']);

    Route::get('/logout', [SessionsController::class, 'destroy']);
    Route::get('/login', function () {
        return view('static-sign-in');
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

});

Route::get('/login', function () {
    return view('session/login-session');
})->name('login');

Route::get('bukti_faktur/{image}/{token}', [PenagihanController::class, 'bukti_faktur'])
    ->name('penagihan.bukti_faktur');
