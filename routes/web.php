<?php

use App\Http\Controllers\Admin\FormSubmissionController as AdminFormSubmissionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublicFormController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicFormController::class, 'show'])->name('form.show');
Route::post('/submit', [PublicFormController::class, 'submit'])
    ->middleware('throttle:10,1')
    ->name('form.submit');
Route::get('/sucesso', [PublicFormController::class, 'success'])->name('form.success');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.perform');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('submissions', [AdminFormSubmissionController::class, 'index'])->name('submissions.index');
    Route::get('submissions/export', [AdminFormSubmissionController::class, 'export'])->name('submissions.export');
    Route::get('submissions/{submission}', [AdminFormSubmissionController::class, 'show'])->name('submissions.show');
    Route::delete('submissions/{submission}', [AdminFormSubmissionController::class, 'destroy'])->name('submissions.destroy');
    Route::get('submissions/{submission}/download', [AdminFormSubmissionController::class, 'download'])->name('submissions.download');
});
