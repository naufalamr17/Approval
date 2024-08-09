<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\BusinessTripController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\SuratTugasController;
use App\Http\Controllers\TicketRequestController;
use App\Models\BusinessTrip;
use App\Models\flight;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('surat-tugas/{id}', [SuratTugasController::class, 'show'])->name('view-surat-tugas');
Route::get('fpd/{id}', [BusinessTripController::class, 'show'])->name('view-fpd');

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return redirect('/dashboard');
    });
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/submission', function () {
        return view('submission');
    })->name('submission');
    Route::post('/store-submission', [SubmissionController::class, 'store'])->name('store-submission');
    Route::get('/create-ticket-req', [SubmissionController::class, 'ticket'])->name('create-ticket-req');

    Route::get('/surat-tugas', [SuratTugasController::class, 'index'])->name('surat-tugas');
    Route::post('/store-surat-tugas', [SuratTugasController::class, 'store'])->name('store-surat-tugas');
    Route::get('/create-surat-tugas', [SuratTugasController::class, 'create'])->name('create-surat-tugas');
    Route::get('edit-surat-tugas/{id}', [SuratTugasController::class, 'edit'])->name('edit-surat-tugas');
    Route::put('surat-tugas/{id}', [SuratTugasController::class, 'update'])->name('update-surat-tugas');
    Route::get('/surat-tugas/approve/{id}', [SuratTugasController::class, 'approve'])->name('approve-surat-tugas');
    Route::get('/surat-tugas/reject/{id}', [SuratTugasController::class, 'reject'])->name('reject-surat-tugas');
    Route::delete('/delete-surat-tugas/{id}', [SuratTugasController::class, 'destroy'])->name('delete-surat-tugas');
    Route::get('/surat-tugas/print/{id}', [SuratTugasController::class, 'print'])->name('print-surat-tugas');
    
    Route::get('/perjalanan-dinas', [BusinessTripController::class, 'index'])->name('perjalanan-dinas');
    Route::get('/form-perjalanan-dinas', [SuratTugasController::class, 'formPerjalananDinas'])->name('form-perjalanan-dinas');
    Route::post('/store-form', [SuratTugasController::class, 'storeFPD'])->name('store-form');
    Route::get('/fpd/approve/{id}', [BusinessTripController::class, 'approve'])->name('approve-fpd');
    Route::get('/fpd/reject/{id}', [BusinessTripController::class, 'reject'])->name('reject-fpd');
    Route::delete('/fpd/delete/{id}', [BusinessTripController::class, 'destroy'])->name('delete-fpd');
    Route::get('/fpd/print/{id}', [BusinessTripController::class, 'print'])->name('print-fpd');
    
    Route::get('/flight', [FlightController::class, 'index'])->name('flight');
    
    Route::get('/ticket-request', [TicketRequestController::class, 'index'])->name('ticket-request');
    Route::post('/store-ticket-request', [TicketRequestController::class, 'store'])->name('store-ticket-request');
    Route::get('/ticket-request/approve/{id}', [TicketRequestController::class, 'approve'])->name('approve-ticket-request');
    Route::get('/ticket-request/reject/{id}', [TicketRequestController::class, 'reject'])->name('reject-ticket-request');
    Route::delete('/delete-ticket-request/{id}', [TicketRequestController::class, 'destroy'])->name('delete-ticket-request');
    Route::get('edit-ticket-request/{id}', [TicketRequestController::class, 'edit'])->name('edit-ticket-request');
    Route::put('ticket-request/{id}', [TicketRequestController::class, 'update'])->name('update-ticket-request');
    
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees');
    Route::post('/store-employee', [EmployeeController::class, 'store'])->name('store-employee');
});

Route::get('/tables', function () {
    return view('tables');
})->name('tables')->middleware('auth');

Route::get('/wallet', function () {
    return view('wallet');
})->name('wallet')->middleware('auth');

Route::get('/RTL', function () {
    return view('RTL');
})->name('RTL')->middleware('auth');

Route::get('/profile', function () {
    return view('account-pages.profile');
})->name('profile')->middleware('auth');

Route::get('/signin', function () {
    return view('account-pages.signin');
})->name('signin');

Route::get('/signup', function () {
    return view('account-pages.signup');
})->name('signup')->middleware('guest');

Route::get('/sign-up', [RegisterController::class, 'create'])
    ->middleware('guest')
    ->name('sign-up');

Route::post('/sign-up', [RegisterController::class, 'store'])
    ->middleware('guest');

Route::get('/sign-in', [LoginController::class, 'create'])
    ->middleware('guest')
    ->name('sign-in');

Route::post('/sign-in', [LoginController::class, 'store'])
    ->middleware('guest');

Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::get('/forgot-password', [ForgotPasswordController::class, 'create'])
    ->middleware('guest')
    ->name('password.request');

Route::post('/forgot-password', [ForgotPasswordController::class, 'store'])
    ->middleware('guest')
    ->name('password.email');

Route::get('/reset-password/{token}', [ResetPasswordController::class, 'create'])
    ->middleware('guest')
    ->name('password.reset');

Route::post('/reset-password', [ResetPasswordController::class, 'store'])
    ->middleware('guest');

Route::get('/laravel-examples/user-profile', [ProfileController::class, 'index'])->name('users.profile')->middleware('auth');
Route::put('/laravel-examples/user-profile/update', [ProfileController::class, 'update'])->name('users.update')->middleware('auth');
Route::get('/laravel-examples/users-management', [UserController::class, 'index'])->name('users-management')->middleware('auth');
